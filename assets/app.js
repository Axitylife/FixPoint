const problem = document.querySelector('[name="problem"]');
const counter = document.querySelector("#counter");
if (problem && counter) {
  const update = () => (counter.textContent = problem.value.length);
  problem.addEventListener("input", update);
  update();
}
const form = document.querySelector("#requestForm");
if (form) {
  form.addEventListener("submit", (e) => {
    const phone = form.phone.value.replace(/\D/g, "");
    if (phone.length < 10) {
      e.preventDefault();
      document.querySelector("#formError").textContent =
        "Введите корректный номер телефона.";
    }
  });
}
