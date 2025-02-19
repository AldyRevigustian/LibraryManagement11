from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from selenium.common.exceptions import TimeoutException
import time
from selenium.webdriver.chrome.options import Options

chrome_options = Options()
chrome_options.add_argument("--start-fullscreen")

service = Service("C://chromedriver-win32/chromedriver.exe")
driver = webdriver.Chrome(service=service)

urls = [
    "https://www.gramedia.com/vendor/gramedia-pustaka-utama?sort=popular",
    "https://www.gramedia.com/vendor/gramedia-widiasarana-indonesia?sort=popular",
    "https://www.gramedia.com/vendor/bhuana-ilmu-populer?sort=popular",
    "https://www.gramedia.com/vendor/elex-media-komputindo?sort=popular",
    "https://www.gramedia.com/vendor/mc?sort=popular",
    "https://www.gramedia.com/vendor/kepustakaan-populer-gramedia?sort=popular",
    "https://www.gramedia.com/vendor/phoenix-gramedia-indonesia?sort=popular",
]

for index, url in enumerate(urls):
    driver.get(url)

    time.sleep(1)
    click_count = 0
    max_clicks = 10
    max_links = 500

    book_links = []
    while click_count < max_clicks and len(book_links) < max_links:
        try:
            load_more_button = WebDriverWait(driver, 10).until(
                EC.element_to_be_clickable(
                    (By.CSS_SELECTOR, '[data-testid="productListLoadMore"]')
                )
            )
            load_more_button.click()
            click_count += 1

            time.sleep(2)
            driver.execute_script("window.scrollTo(0, document.body.scrollHeight);")

            link_elements = driver.find_elements(
                By.CSS_SELECTOR, 'a[data-sentry-element="LinkComponenent"]'
            )

            for link_element in link_elements:
                book_link = link_element.get_attribute("href")
                if book_link not in book_links:
                    book_links.append(book_link)

            if len(book_links) >= max_links:
                break

        except TimeoutException:
            print("Semua produk telah dimuat.")
            break

    file_name = f"links/book_links_{index + 1}.txt"
    with open(file_name, "w") as file:
        for link in book_links[:max_links]:
            file.write(link + "\n")

driver.quit()
