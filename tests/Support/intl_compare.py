"""Compare Korean responses against an archive, without creating a Git worktree."""

import difflib
import base64
import io
import json
import os
import shlex
from pathlib import Path
import subprocess
import tarfile
import tempfile


root = Path(__file__).resolve().parents[2]
with tempfile.TemporaryDirectory(prefix="intl-01-") as scratch:
    scratch = Path(scratch)
    base = scratch / "base"
    base.mkdir()
    archive = subprocess.check_output(["git", "archive", "0662117"], cwd=root)
    with tarfile.open(fileobj=io.BytesIO(archive)) as bundle:
        bundle.extractall(base, filter="data")
    for relative in ["vendor", "node_modules", "public/build"]:
        (base / relative).symlink_to(root / relative, target_is_directory=True)
    if (root / ".env").is_file():
        (base / ".env").symlink_to(root / ".env")
    for relative in ["storage/framework/views", "storage/framework/sessions", "storage/framework/cache/data", "storage/logs", "bootstrap/cache"]:
        (base / relative).mkdir(parents=True, exist_ok=True)
    results = []
    for label, checkout in [("baseline", base), ("implementation", root)]:
        env = os.environ.copy()
        env.update({
            "APP_ENV": "testing", "APP_DEBUG": "false",
            "APP_KEY": "base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=",
            "APP_URL": "https://j-curve.co.kr", "SEO_PUBLIC_URL": "https://j-curve.co.kr",
            "APP_LOCALE": "ko", "APP_FALLBACK_LOCALE": "en", "APP_FAKER_LOCALE": "en_US",
            "DB_CONNECTION": "sqlite", "DB_DATABASE": str(scratch / (label + ".sqlite")), "DB_URL": "",
            "SESSION_DRIVER": "array", "CACHE_STORE": "array", "QUEUE_CONNECTION": "sync",
            "MAIL_MAILER": "array", "BCRYPT_ROUNDS": "4", "GTM_ID": "",
            "APP_BASE_PATH": str(checkout),
        })
        Path(env["DB_DATABASE"]).touch()
        output = scratch / (label + ".json")
        command = ["php", str(root / "tests/Support/intl_snapshot.php"), str(checkout), str(output)]
        print(label + ": " + shlex.join(command), flush=True)
        subprocess.run(command, env=env, cwd=checkout, check=True)
        results.append(json.loads(output.read_text()))
    old, new = results
    catalog_equal = old["catalog"] == new["catalog"]
    differences = []
    for path in sorted(set(old["pages"]) | set(new["pages"])):
        before, after = old["pages"].get(path), new["pages"].get(path)
        if before != after:
            differences.append(path)
            if before and after:
                print("DIFF " + base64.b64decode(path).decode("utf-8", errors="replace"))
                before_html = base64.b64decode(before["html_base64"]).decode("utf-8", errors="replace")
                after_html = base64.b64decode(after["html_base64"]).decode("utf-8", errors="replace")
                print("".join(list(difflib.unified_diff(before_html.splitlines(True), after_html.splitlines(True), n=1))[:30]))
    print("Korean sitemap entries identical (including order/lastmod): " + str(catalog_equal))
    print("Korean rendered pages: " + str(len(old["pages"])))
    print("HTML/status differences: " + str(len(differences)))
    print("Normalization: CSRF meta/input; encrypted valid_from input; 5-character random sbg/sgl/sdot SVG IDs. Vite assets shared, no hash normalization.")
    print("Temporary archive, SQLite databases, snapshots: removed on exit.")
    if differences or not catalog_equal or any(page["status"] != 200 for page in new["pages"].values()):
        raise SystemExit(1)
