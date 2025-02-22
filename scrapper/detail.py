from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
import os
import json
import requests
import random
import re
from selenium.webdriver.chrome.options import Options

chrome_options = Options()
chrome_options.page_load_strategy = "eager"  # Tidak menunggu semua resource selesai
chrome_options.add_argument("--headless=new")  # Gunakan headless mode
chrome_options.add_argument("--no-sandbox")  # Bisa meningkatkan performa di beberapa kasus


kategori_dict = {
    kategori.upper(): i + 1
    for i, kategori in enumerate(
        [
            "Buku",
            "Fiksi",
            "Agama",
            "Hukum",
            "Pendidikan",
            "Alam",
            "Arsitektur",
            "Pengembangan Diri",
            "Humor",
            "Biografi & Autobiografi",
            "Ilmu Politik",
            "Ilmu Sosial",
            "Bisnis & Ekonomi",
            "Psikologi",
            "Keluarga & Hubungan",
            "Puisi",
            "Referensi",
            "Ensiklopedia",
            "Kamus",
            "Resep & Masakan",
            "Komik & Novel Grafis",
            "Romantis",
            "Novel",
            "Komputer",
            "Pemrograman",
            "Sejarah",
            "Desain",
            "Seni",
            "Matematika",
            "Medis",
            "Teknologi & Teknik",
            "Tubuh, Pikiran & Jiwa",
            "Akuntansi",
            "Sains",
            "Fisika",
            "Kimia"
        ]
    )
}


service = Service("C://chromedriver-win32/chromedriver.exe")
driver = webdriver.Chrome(service=service, options=chrome_options)

error_links = []  # Menyimpan link yang gagal diproses

def save_error_links():
    if error_links:
        with open("error.txt", "w") as f:
            for link in error_links:
                f.write(link + "\n")
        print("⚠️ Link yang gagal telah disimpan ke error.txt")

def download_image(image_url, isbn):
    image_path = f"storage/cover_buku/{isbn}.jpg"

    if os.path.exists(image_path):
        print(f"Gambar untuk ISBN {isbn} sudah ada. Menggunakan gambar yang sudah ada.")
        return image_path
    try:
        response = requests.get(image_url, stream=True)
        if response.status_code == 200 and "image" in response.headers["Content-Type"]:
            with open(image_path, "wb") as file:
                for chunk in response.iter_content(1024):
                    file.write(chunk)
            return image_path
    except Exception as e:
        print(f"Error saat mengunduh gambar: {e}")
    return None


books = []
for index in range(1, 2):
    file_name = f"links/book_links_{index}.txt"
    if os.path.exists(file_name):
        with open(file_name, "r") as file:
            book_links = [line.strip() for line in file.readlines()]

        for link in book_links:
            driver.set_page_load_timeout(5)
            try:
                driver.get(link)
            except:
                print("Halaman terlalu lama dimuat, lanjut ke halaman berikutnya.")

            try:
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located(
                        (
                            By.CSS_SELECTOR,
                            '[data-testid="productDetailSpecificationItemValue"]',
                        )
                    )
                )
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located(
                        (
                            By.CSS_SELECTOR,
                            '[data-testid="productDetailTitle"]',
                        )
                    )
                )
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located(
                        (
                            By.CSS_SELECTOR,
                            '[data-testid="productDetailAuthor"]',
                        )
                    )
                )
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located(
                        (
                            By.CSS_SELECTOR,
                            '[data-testid="productDetailSpecificationItemValue"]',
                        )
                    )
                )
                WebDriverWait(driver, 5).until(
                    EC.presence_of_element_located(
                        (
                            By.CSS_SELECTOR,
                            '[data-testid="productDetailDescriptionContainer"]',
                        )
                    )
                )

                try:
                    author = driver.find_element(
                        By.CSS_SELECTOR, '[data-testid="productDetailAuthor"]'
                    ).text
                except:
                    author = "Tidak tersedia"

                try:
                    title = driver.find_element(
                        By.CSS_SELECTOR, '[data-testid="productDetailTitle"]'
                    ).text
                except:
                    title = "Tidak tersedia"

                try:
                    year = driver.find_elements(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailSpecificationItemValue"]',
                    )[1].text
                except IndexError:
                    year = "Tidak tersedia"

                try:
                    image_url = driver.find_element(
                        By.CSS_SELECTOR, '[data-id="productDetailImage#0"]'
                    ).get_attribute("src")
                except:
                    image_url = "Tidak tersedia"

                try:
                    description = driver.find_element(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailDescriptionContainer"]',
                    ).text
                except:
                    description = "Tidak ada deskripsi tersedia"

                description = re.sub(r"[^\x20-\x7E\n]", "", description)

                try:
                    halaman = driver.find_element(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailSpecificationItem#3"] [data-testid="productDetailSpecificationItemValue"]',
                    ).text
                except:
                    halaman = "Tidak tersedia"

                try:
                    panjang = driver.find_element(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailSpecificationItem#5"] [data-testid="productDetailSpecificationItemValue"]',
                    ).text.replace(" cm", "")
                    panjang = str(int(float(panjang)))
                except:
                    panjang = "Tidak tersedia"

                try:
                    lebar = driver.find_element(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailSpecificationItem#6"] [data-testid="productDetailSpecificationItemValue"]',
                    ).text.replace(" cm", "")
                    lebar = str(int(float(lebar)))
                except:
                    lebar = "Tidak tersedia"

                deskripsi_fisik = f"{halaman} Halaman; {panjang} x {lebar} cm"

                isbn = (
                    driver.find_element(
                        By.CSS_SELECTOR,
                        '[data-testid="productDetailSpecificationItem#2"] [data-testid="productDetailSpecificationItemValue"]',
                    ).text
                    or None
                )

                breadcrumbs = driver.find_elements(
                    By.CSS_SELECTOR, '[data-sentry-component="BreadcrumbsItem"] a'
                )

                kategori = [
                    breadcrumb.text
                    for breadcrumb in driver.find_elements(
                        By.CSS_SELECTOR, '[data-sentry-component="BreadcrumbsItem"] a'
                    )
                    if breadcrumb.text.upper() != "HOME"
                ]
                kategori.reverse()

                kategori_id = next(
                    (
                        kategori_dict.get(k.upper())
                        for k in kategori
                        if k.upper() in kategori_dict
                    ),
                    None,
                )

                if isbn and title != "Tidak tersedia":
                    # image_path = download_image(image_url, isbn)
                    image_path = f"storage/cover_buku/{isbn}.jpg"

                    books.append(
                        {
                            "ISBN": int(isbn),
                            "judul": title,
                            "kontributor": author,
                            "penerbit_id": index,
                            "stok": random.randint(0, 30),
                            "kategori_id": kategori_id,
                            "deskripsi": description,
                            "deskripsi_fisik": deskripsi_fisik,
                            "tahun_terbit": year,
                            "foto": image_path,
                        }
                    )
                    print(f"Detail produk '{title}' berhasil diambil.")
                else:
                    error_links.append(link)
                    print(f"Detail produk tidak lengkap untuk buku '{title}'.")

            except Exception as e:
                print(f"Gagal mengambil detail produk dari {link}: {e}")
                error_links.append(link)

save_error_links()
with open("products.json", "w", encoding="utf-8") as file:
    json.dump(books, file, ensure_ascii=False, indent=4)

driver.quit()
