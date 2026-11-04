"""Run the seven authorized Blade mutations, restoring exact bytes in finally.

Run from the repository root: python3 tests/Support/seo_kw_01c_mutations.py
Only temporary Blade edits, tests/** evidence and the specified compiled-view
directory are written. Git commands are read-only; the DB is SQLite :memory:.
"""

import hashlib
import json
import os
from pathlib import Path
import subprocess
import xml.etree.ElementTree as ET


ROOT = Path(__file__).resolve().parents[2]
EVIDENCE = ROOT / "tests/SEO-KW-01C-EVIDENCE"
VIEWS = ROOT / "resources/views"
COMPILED = Path("/private/tmp/jcurve-seo-kw-01c/views")
ENV = dict(os.environ, APP_ENV="testing", DB_CONNECTION="sqlite",
           DB_DATABASE=":memory:", DB_URL="", CACHE_STORE="array",
           SESSION_DRIVER="array", LOG_CHANNEL="stderr",
           VIEW_COMPILED_PATH=str(COMPILED))

MUTATIONS = [
    {
        "id": "01-head-json-hex-tag",
        "file": "partials/jc/head.blade.php",
        "old": " | JSON_HEX_TAG",
        "new": "",
        "filter": "test_head_jsonld_escapes_script_endings_and_decodes_html_entities",
        "red": ["test_head_jsonld_escapes_script_endings_and_decodes_html_entities"],
    },
    {
        "id": "02-faq-json-hex-tag",
        "file": "partials/jc/schema-faq.blade.php",
        "old": " | JSON_HEX_TAG",
        "new": "",
        "filter": "test_faq_jsonld_escapes_script_endings_in_an_insight_question",
        "red": ["test_faq_jsonld_escapes_script_endings_in_an_insight_question"],
    },
    {
        "id": "03-guest-noindex",
        "file": "layouts/guest.blade.php",
        "old": '        <meta name="robots" content="noindex, follow">\n',
        "new": "",
        "filter": "test_guest_pages_are_noindex_and_have_their_korean_titles",
        "red": ["test_guest_pages_are_noindex_and_have_their_korean_titles"],
    },
    {
        "id": "04-empty-category-noindex",
        "file": "insights/category.blade.php",
        "old": "@if ($insights->total() === 0 && ! in_array($category->slug, ['seo', 'link-building'], true))\n    @section('robots', 'noindex, follow')\n@endif\n",
        "new": "",
        "filter": "test_only_empty_nonpreserved_categories_are_noindex",
        "red": ["test_only_empty_nonpreserved_categories_are_noindex"],
    },
    {
        "id": "05-rankfree-sd-page",
        "file": "solutions/rankfree.blade.php",
        "old": "@section('sd_page', '랭크프리')\n",
        "new": "",
        "filter": "test_page_breadcrumb_and_service_contract.*rankfree",
        "red": ["test_page_breadcrumb_and_service_contract"],
    },
    {
        "id": "06-description-str-limit-155",
        "file": "insights/show.blade.php",
        "old": "$sdMetaDesc = $sdLimit(strip_tags((string) ($insight->meta_description ?: $insight->excerpt)), 160);",
        "new": "$sdMetaDesc = \\Illuminate\\Support\\Str::limit(strip_tags((string) ($insight->meta_description ?: $insight->excerpt)), 155);",
        "filter": "test_new_articles_render_their_own_canonical_metadata|test_insight_description_uses_160_characters",
        "red": ["test_new_articles_render_their_own_canonical_metadata", "test_insight_description_uses_160_characters"],
    },
    {
        "id": "07-footer-self-children",
        "file": "partials/jc/footer.blade.php",
        "old": "                    @foreach ($jcMenu['self']['children'] ?? [] as $link)\n                        <li><a href=\"{{ $link['href'] }}\">{{ $link['label'] }}</a></li>\n                    @endforeach\n",
        "new": "",
        "filter": "test_footer_has_both_reward_links_and_desktop_header_has_one_self_link",
        "red": ["test_footer_has_both_reward_links_and_desktop_header_has_one_self_link"],
    },
]


def git(*args):
    return subprocess.check_output(["git", *args], cwd=ROOT).decode()


def view_hashes():
    return {str(p.relative_to(ROOT)): hashlib.sha256(p.read_bytes()).hexdigest()
            for p in sorted(VIEWS.rglob("*")) if p.is_file()}


def run_tests(name, selector):
    # Restoring source bytes can leave a newer compiled mutation in Blade's
    # cache. Start each subprocess with fresh views in this exact tmp path.
    cleared = 0
    for compiled in COMPILED.glob("*.php"):
        if compiled.is_file():
            compiled.unlink()
            cleared += 1
    relative_xml = f"tests/SEO-KW-01C-EVIDENCE/{name}.xml"
    command = ["php", "artisan", "test", "--filter=" + selector,
               "--do-not-cache-result", "--log-junit=" + relative_xml]
    run = subprocess.run(command, cwd=ROOT, env=ENV, capture_output=True,
                         text=True, timeout=120)
    output = run.stdout + run.stderr
    (EVIDENCE / f"{name}.log").write_text(output)
    report = ET.parse(ROOT / relative_xml).getroot()
    cases = list(report.iter("testcase"))
    failures = [case.attrib["name"] for case in cases
                if case.find("failure") is not None or case.find("error") is not None]
    return {"command": command, "exit_code": run.returncode,
            "compiled_views_cleared": cleared,
            "tests": len(cases), "red_tests": failures,
            "output": output.strip()}


def main():
    EVIDENCE.mkdir(parents=True, exist_ok=True)
    COMPILED.mkdir(parents=True, exist_ok=True)
    baseline = {"head": git("rev-parse", "HEAD").strip(),
                "view_diff_stat": git("diff", "--stat", "--", "resources/views"),
                "view_diff": git("diff", "--", "resources/views"),
                "view_hashes": view_hashes()}
    (EVIDENCE / "views-before.json").write_text(json.dumps(baseline, ensure_ascii=False, indent=2) + "\n")
    selector = "|".join(m["filter"] for m in MUTATIONS)
    healthy = run_tests("mutation-baseline", selector)
    print(json.dumps({"baseline": healthy}, ensure_ascii=False), flush=True)
    if healthy["exit_code"] or healthy["red_tests"] or healthy["tests"] == 0:
        raise RuntimeError("The unmutated targets must all pass before experiments")

    results = []
    try:
        for mutation in MUTATIONS:
            path = VIEWS / mutation["file"]
            original = path.read_bytes()
            expected_hash = baseline["view_hashes"][str(path.relative_to(ROOT))]
            if hashlib.sha256(original).hexdigest() != expected_hash:
                raise RuntimeError(f"External change detected before {path}; refusing to overwrite")
            old, new = mutation["old"].encode(), mutation["new"].encode()
            if original.count(old) != 1:
                raise RuntimeError(f"Expected one exact mutation target: {path}")
            mutated = original.replace(old, new, 1)
            result = {"id": mutation["id"], "file": str(path.relative_to(ROOT)),
                      "old": mutation["old"], "new": mutation["new"]}
            try:
                path.write_bytes(mutated)
                result.update(run_tests(mutation["id"], mutation["filter"]))
            finally:
                # Never overwrite an unrelated concurrent edit on restoration.
                if path.read_bytes() != mutated:
                    raise RuntimeError(f"Concurrent edit of active mutation: {path}")
                path.write_bytes(original)
                result["restored_bytes"] = path.read_bytes() == original
                result["view_diff_stat"] = git("diff", "--stat", "--", "resources/views")
                result["all_view_hashes_equal"] = view_hashes() == baseline["view_hashes"]
                result["full_view_diff_equal"] = git("diff", "--", "resources/views") == baseline["view_diff"]
            # PHPUnit uses 2 for a thrown JSON parse error and 1 for an
            # assertion failure; both are expected red mutation outcomes.
            result["caught"] = (result["exit_code"] in (1, 2) and all(
                any(name in failed for failed in result["red_tests"])
                for name in mutation["red"]))
            results.append(result)
            print(json.dumps(result, ensure_ascii=False), flush=True)
            if not all([result["caught"], result["restored_bytes"],
                        result["all_view_hashes_equal"], result["full_view_diff_equal"],
                        result["view_diff_stat"] == baseline["view_diff_stat"]]):
                raise RuntimeError(f"Mutation or restoration proof failed: {mutation['id']}")
    finally:
        final = {"head": git("rev-parse", "HEAD").strip(),
                 "view_diff_stat_before": baseline["view_diff_stat"],
                 "view_diff_stat_after": git("diff", "--stat", "--", "resources/views"),
                 "all_view_hashes_equal": view_hashes() == baseline["view_hashes"],
                 "full_view_diff_equal": git("diff", "--", "resources/views") == baseline["view_diff"],
                 "view_files": len(baseline["view_hashes"]), "mutations": results}
        (EVIDENCE / "mutations.json").write_text(json.dumps(final, ensure_ascii=False, indent=2) + "\n")
    restored = run_tests("mutation-restored", selector)
    print(json.dumps({"restored": restored, "views": {k: v for k, v in final.items() if k != "mutations"}}, ensure_ascii=False), flush=True)
    if restored["exit_code"] or restored["red_tests"] or restored["tests"] != healthy["tests"]:
        raise RuntimeError("Restored target tests must all pass again")


if __name__ == "__main__":
    main()
