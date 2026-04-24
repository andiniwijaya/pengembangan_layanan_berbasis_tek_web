// DARK MODE
function toggleTheme() {
  document.body.classList.toggle("dark");

  localStorage.setItem(
    "theme",
    document.body.classList.contains("dark") ? "dark" : "light",
  );
}

document.addEventListener("DOMContentLoaded", function () {
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
  }
});

// AUTO TOTAL TRANSAKSI
document.addEventListener("DOMContentLoaded", function () {
  const qtyInputs = document.querySelectorAll(".qty");

  qtyInputs.forEach((input) => {
    input.addEventListener("input", updateTotal);
  });

  function updateTotal() {
    let total = 0;

    document.querySelectorAll("tbody tr").forEach((row) => {
      let price = parseFloat(row.querySelector(".price")?.innerText) || 0;
      let qty = parseInt(row.querySelector(".qty")?.value) || 0;

      let subtotal = price * qty;

      if (row.querySelector(".subtotal")) {
        row.querySelector(".subtotal").innerText = subtotal;
      }

      total += subtotal;
    });

    if (document.getElementById("total")) {
      document.getElementById("total").innerText = total;
    }
  }
});

// SEARCH PRODUK REALTIME
const searchInput = document.getElementById("search");

if (searchInput) {
  searchInput.addEventListener("keyup", function () {
    let keyword = this.value.toLowerCase();

    document.querySelectorAll(".product-row").forEach((row) => {
      let text = row.innerText.toLowerCase();
      row.style.display = text.includes(keyword) ? "" : "none";
    });
  });
}

// TOAST
function showToast(message = "Berhasil!") {
  const toastEl = document.getElementById("toastSuccess");
  if (!toastEl) return;

  toastEl.querySelector(".toast-body").innerText = message;

  const toast = new bootstrap.Toast(toastEl);
  toast.show();
}

// LOADING SCREEN
window.addEventListener("load", function () {
  const loader = document.getElementById("loader");
  if (loader) {
    loader.style.display = "none";
  }
});

// tampilkan loader saat pindah halaman
document.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => {
    const loader = document.getElementById("loader");
    if (loader) {
      loader.style.display = "flex";
    }
  });
});
