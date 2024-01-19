const togglePopup = (target, popup) => {
  const closePopup = (e) => {
    event.preventDefault();
    popupElement.classList.remove("popup-shown");
  };

  const targetElement = document.querySelector(target);

  const popupElement = document.querySelector(popup);
  const popupContent = popupElement.children[0];

  targetElement.addEventListener("click", (e) => {
    popupElement.classList.add("popup-shown");
  });

  const closePopupElement = document.querySelector(`${popup} .popup-abort`);
  closePopupElement.addEventListener("click", closePopup);
};

const deleteBook = (book_id) => {
  const deleteButton = document.querySelector(".button-delete-confirm");

  const bookEventListener = () => {
    window.location.href = "books.delete.php?id=" + book_id;
  };

  deleteButton.removeEventListener("click", bookEventListener);
  deleteButton.addEventListener("click", bookEventListener);

  togglePopup("#delete-" + book_id, "#popup-delete");
};

const updateBook = (book_id, book) => {
  const updateFormElement = document.querySelector(`#popup-update form`);
  updateFormElement.setAttribute("action", `books.update.php?id=${book_id}`);
  
  console.log(book);

  updateFormElement.title.value = book.judul;
  updateFormElement.category.value = book.kategori_id;
  updateFormElement.year.value = book.tahun_terbit;
  updateFormElement.publisher.value = book.penerbit;

  togglePopup("#update-" + book_id, "#popup-update");
};
