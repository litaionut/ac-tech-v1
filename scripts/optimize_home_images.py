#!/usr/bin/env python3
"""Download homepage placeholder images and export optimized WebP variants."""

from __future__ import annotations

import json
from io import BytesIO
from pathlib import Path
from urllib.request import urlopen

from PIL import Image

THEME_ROOT = Path(__file__).resolve().parent.parent
OUTPUT_DIR = THEME_ROOT / "assets" / "images" / "home"
MANIFEST_PATH = THEME_ROOT / "scripts" / "home-images-manifest.json"
WEBP_QUALITY = 78

IMAGE_SETS = (
    {
        "output_dir": THEME_ROOT / "assets" / "images" / "home",
        "manifest_key": "home",
        "images": [
            {
                "slug": "hero-hvac",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuDimSyLEB8uq9yEVx3eUGHqC7g1xkKYIjs8GgozOzAYwIby2u-sj9O5RTjUqVn0mTPA2p9AM_KfU909J-ITp9OEvScxZHkUbZiRtsNQ9gb0vhzks02Z1h0L-W5mWeGraRDtYOEbqbMUHZAgB_qWbspBBjXAyZ62IsnnyMZWHP5r4fklAPxpH6xiNRuTAXxZ4zkfs0MHcZ9a3ZLDK5KhgLvhZA7N3ZEYawIKXVeo9gg5qz4tSWTWMy-gDUhZsWBxrSAEPq9QviWYf-Oj",
                "widths": [800, 1200],
                "aspect": (4, 3),
            },
            {
                "slug": "service-instalare",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuA1qSX6BNdokxMONn7DPNfvBsiNGchGUF0jNVcja4U9FLGAFGIx8DLhjTTzR6zubLozHUQROswa8tXO-vIius5zLXKvmqTuaLEJ62AVSroG2UVauXf7lU7F3PVaXzKGKTr_bpEWujbL9zQSdL0kJv44NmY0Rw_qqX2LNpGGOpKgibbNFIIWMP6aC7vWj0xpZdh3MggRJgRLF1yfGj46VRjG1bwtg7xhv8CbcuW1GgDbItcTWy9UxpjQ6rOZW34u_W9T5GKaAqatm5Td",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "service-igienizare",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuDsb9680TIJUIX4n2E6HCHd3GIiHomNcOsaBF0R-ONSUoqMB5gLjkhhVjUx1o6ne5gE_xZt_oC8FKFJfao7nzT96ri5ZxuUfpgRIN-fO9jSvbTWVS6K-21T3_k9a9zcsgFOf9KjPUKEUsodKUKEXhSUDJVaSqRgnUDEWAEtxS0-_vuHq1ZdYIeBm6KPSQFGh2VJ6db2Q5N5QGPm7yRy9seySfWUqIGAvSTlG0845Nd29c6tM3tU_X7vdq-wxtzzV_S8uuBuxe-fagaU",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "service-diagnostic",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuCQOr0e_LkVRPGJ92erkHBkS3y8qSN0pLxF04fZ0bq4D0sHAN_aYtY0dHODR63yks4F6rTWViMp5qcx1m-XotTSwp_DQW3T0yqMTtouA96PgVoo07BOyXwvk_9RpT-b3Tfz9gsn8t-5xLqyfQjFOskLwqMBlPCFhhdIy2SW6Yql_3nYP6BxkWdNUBX6uOCEKcyzGzLRvvfRAJ7RqcDe3tv8Xd9cQNEVtG9XVACP3M_uM-TTn2KtjVcFNgYy2WsZLN-jp7EdiW-WE13j",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "service-mentenanta",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuD3XyPkQR-0-FDViqMq9FOD_swulhD4ZitPgetu2W46bN7hrRtF12oY1bBidsSn3TeSiwo6j5aGCVV4JVSFha9alosFQsvxKS1W5gVNdeQy6VP7dz2UBYiZ0rPPYSijRIZDTkrgFFJpQAbo4O9c2k9fYB0M2i4_K8IFDfLQ75182iqJEB4q0ZgNV7qnYqIJm0lmnx_tr2kX7PnO02pwC9_wX3wZlMwKpaW--zmJ8qS73DU_1Sy3udgZycEwaZHgws3CL5S6czOcB8OW",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "avatar-review-1",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuDqfgLMqN4EkF65qunySUR712r1XfXDy6wct08iHXDl4aFnTZAVkv85jnw9Dne4GIUyJBF_wFb6wghwQm6MeyLdSzfJCHcgT1qOE_5kBrYaUKQTTB610_mupbMFHzUtYnezVhX3fvB2iXw82j-75EguajVkfvdd0kzshbwq7cvIcBRrz5cGcl5L_PFQU1qOiP4MmP3VB3CY_2SHsoRMji6qtptz675otBO-BV1CGdensFeATWUQkBx2043t0iyMAEaz_2YRgm3ceDiv",
                "widths": [96],
                "aspect": (1, 1),
            },
            {
                "slug": "avatar-review-2",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuB5sS4RID6ta5RxJBJLcFQ5k3m5lKlCv93GaQEbwUcuD2aqZ6vLgKOeDhqDQa8smnKgSVjxAwEZpaI8V7vlHutQeP7pEQ3zACcMFfpWnujKeTJS2YQQFtYAV4ew-f91wOnVWmsUGnneuOoh8oRqlGPJWCE-dk3LY3LMUEw7B2eQFe5znih08zhXBdUC3T22NeP5Dh75t20Kl1CHGjMD5M6QZWy10pZD1z8KOi-Ataaii8P-WOnfFRcEL7c1aWQ-r1F577OrGq0EVFfY",
                "widths": [96],
                "aspect": (1, 1),
            },
            {
                "slug": "avatar-review-3",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuDUOlnddzJVf_s-x4L3anVVB35k2O5V-5X2dPUlohvOE7WmwGMZZXFBgFT61b8fayDt0bbSI8s8dtfIZYb6pFzqH38H5JrAT99M3gwlotYqjPDaiXen7lhh8Xp0OY06RmZGuj0SrV6mkIKlN4AUspqEW1hEbwS6z8Iju8l9HDXcsJYPW32PRRpd_k3P9GqyER_tuXPqw0oXtCn1o873XY6Hwn_iHFi11KK9YxxD9Gonswdf9TLH2ni-3DHhNTEg12IfuD_d2wAGMbSK",
                "widths": [96],
                "aspect": (1, 1),
            },
        ],
    },
    {
        "output_dir": THEME_ROOT / "assets" / "images" / "service-igienizare",
        "manifest_key": "service-igienizare",
        "images": [
            {
                "slug": "igienizare-hero",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuA8VSaVeAA_NKMV3pZ24xbtopK_7Efd9XIkYGI9spRG03KnH_DQPMEq6o7a8FvKwJ6f4BLqzqCA8taCI_9C3k7WYRpDjn3Q7xF2whQ7Cc2zxfz0pjzwvscaNs_YRf3yHYEwFnKM9zGHcdV4UQNwz4j8xm5WQ7Qo-m4_zV9GTH9eMOKEY6yCU5-D1RcV0hfVhiPSmi9-3zzNeMKx16D7kOf9YNCeX61leABXwneobrLJnuV5La21pgGgpkvP-kzEdPBRTOkoZkEI5mvo",
                "widths": [400, 800, 1200],
                "aspect": (1, 1),
            },
            {
                "slug": "igienizare-filtru",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuAadH5h3pzq-lI5p17GwJB0mNEifNl1dpENl8pHMg7TEOAnEA_CYL9rzRQF_YwX9TkvJrgMwl1HBBr2MIfJHaEIzCc_0XAuzpPLruQVr_g3NilZxXC_P6-yTz_E0VGhiCyQFIpzYsEB9HKN_iJtM0SK8G5y9p-Sjs0PMLgsr1ljGDnpM1CHk9p9SN7LO2WoLVTyMezvSni2RAQG7ELT3Vuk1guDGI8QBSuhzpToCXNEDrvKSe4exE4NPvMu0XGTKaKXBSNjqvUvsuaH",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "igienizare-presiune",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuBFhRPOiYesof591D4xf-UyTyC2qK-zS3d9w73rwHUAt6K2ypUGjOJqChoBcFvMWBxukiuRsopyqbH0kBI9X0vMhJXRUPbQx6A_vnIxLScg_aV6S1H5u1aJ8gBeMrut-BMJxMn3VNoEyKFi9No4rZlurgojLfiQYses_wnF6lZNw6RkctUdysW2n707tK3WPo2XqHJiZ0DzrnqIsPEABp9xd85394MLGuYhUDVqHKbsnfClmpbqyc4lQBv5dP32RJemhwP4BAaIdKMV",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "igienizare-dezinfectare",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuC0w4dxWQjkQZVlAsnxl2sfKv2AEgulYhIwlVKDZZCjX9AthSTT8aBDs3_jaHRbPIP-9ahJ5lxKIym0IOaR7EEKMlq4NDhdHjOPJ8cU-lL2SuSRWMgSxGP5jr-6qqduGaQ1YGtqj1n1-uVIlvg_-GiOZfTNjJ3juZi3DMkAQNNlZAdn4Pv2tKvqjIy_GlvTv-37PpLqHFUpNeZI3vQGGNa1UD_QclGkRIIrkNeVYPGdkwdmEcyHe8PWDQNZZBZApXiAPVCidcPub3xH",
                "widths": [400, 768],
                "aspect": None,
            },
            {
                "slug": "igienizare-echipa",
                "url": "https://lh3.googleusercontent.com/aida-public/AB6AXuAgbURH_xBsi4v818GkKzu2Yz0PKykWUbifTgaAm2DHhDMvbVAbtIcDAanhg6mQcTqlPY-8p85NXvenSsldt6-7DH9aO4qmupQN74et9YIvKTykPVZX9tPW24i1qPaCtFw4dSrsOeEgMIrfTr-3lS76RUna6FxoWjb0jsZh7CUHzoA4i4CIVC0kPrBJZNZXJCJjgpnQGKHfF37RekQ1-tn2h_mr0WCuLY1yFL4WDSaAHa0E4Zo3rUB4Ddh02DXd33_9i4ZKgczE5qlB",
                "widths": [128],
                "aspect": (1, 1),
            },
        ],
    },
)


def validate_webp_output(path: Path, slug: str) -> None:
    """Reject exports that look like broken black-canvas thumbnails (hero-critical)."""
    image = Image.open(path).convert("RGB")
    pixels = list(image.getdata())
    if not pixels:
        raise ValueError(f"{slug}: empty image {path.name}")

    average = sum(sum(pixel) // 3 for pixel in pixels) / len(pixels)
    dark_ratio = sum(1 for pixel in pixels if sum(pixel) // 3 < 25) / len(pixels)

    if "hero" not in slug:
        return

    if dark_ratio > 0.35:
        raise ValueError(f"{slug}: too many dark pixels ({dark_ratio:.0%}) in {path.name}")
    if average < 30:
        raise ValueError(f"{slug}: average brightness too low ({average:.1f}) in {path.name}")


def cleanup_stale_variants(output_dir: Path, slug: str, widths: list[int]) -> None:
    """Remove WebP variants no longer listed in config (e.g. deprecated 400w hero)."""
    allowed = {f"{slug}-{width}.webp" for width in widths}
    for path in output_dir.glob(f"{slug}-*.webp"):
        if path.name not in allowed:
            path.unlink()
            print(f"  removed stale {path.name}")


def resize_image(image: Image.Image, target_width: int, aspect: tuple[int, int] | None) -> Image.Image:
    if aspect:
        target_height = round(target_width * aspect[1] / aspect[0])
        src_w, src_h = image.size
        scale = max(target_width / src_w, target_height / src_h)
        new_w = max(1, round(src_w * scale))
        new_h = max(1, round(src_h * scale))
        resized = image.resize((new_w, new_h), Image.Resampling.LANCZOS)
        left = max(0, (new_w - target_width) // 2)
        top = max(0, (new_h - target_height) // 2)
        return resized.crop((left, top, left + target_width, top + target_height))

    ratio = target_width / image.width
    target_height = max(1, round(image.height * ratio))
    return image.resize((target_width, target_height), Image.Resampling.LANCZOS)


def main() -> None:
    manifest: dict[str, object] = {"quality": WEBP_QUALITY, "sets": {}}

    for image_set in IMAGE_SETS:
        output_dir = Path( image_set["output_dir"] )
        output_dir.mkdir( parents=True, exist_ok=True )
        set_manifest: dict[str, object] = {}

        for item in image_set["images"]:
            slug = item["slug"]
            print(f"Processing {slug}...")
            with urlopen(item["url"]) as response:  # noqa: S310
                source = Image.open(BytesIO(response.read())).convert("RGB")

            variants: list[dict[str, int | str]] = []
            for width in item["widths"]:
                resized = resize_image(source, width, item.get("aspect"))
                filename = f"{slug}-{width}.webp"
                output_path = output_dir / filename
                resized.save(output_path, format="WEBP", quality=WEBP_QUALITY, method=6)
                validate_webp_output(output_path, slug)
                variants.append(
                    {
                        "width": width,
                        "height": resized.height,
                        "file": filename,
                        "bytes": output_path.stat().st_size,
                    }
                )
                print(f"  wrote {filename} ({output_path.stat().st_size} bytes)")

            cleanup_stale_variants(output_dir, slug, item["widths"])

            set_manifest[slug] = {
                "widths": item["widths"],
                "variants": variants,
            }

        manifest["sets"][image_set["manifest_key"]] = set_manifest

    MANIFEST_PATH.write_text(json.dumps(manifest, indent=2), encoding="utf-8")
    print(f"Manifest written to {MANIFEST_PATH}")


if __name__ == "__main__":
    main()
