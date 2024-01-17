const togglePopup = (target, popup) => {
  const closePopup = () => {
    popupElement.classList.toggle("popup-shown");
  };
  const targetElement = document.querySelector(target);

  const popupElement = document.querySelector(popup);
  const popupContent = popupElement.children[0];

  targetElement.addEventListener("click", (e) => {
    popupElement.classList.toggle("popup-shown");
  });

  const closePopupElement = document.querySelector(`${popup} .popup-abort`);
  closePopupElement.addEventListener("click", closePopup);
};
