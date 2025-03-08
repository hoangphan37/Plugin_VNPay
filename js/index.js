const checkboxes = ["checkbank1", "checkbank2", "checkbank3"];

checkboxes.forEach((checkboxId, index) => {
  document.getElementById(checkboxId).addEventListener("change", function () {
    let isChecked = this.checked ? 1 : 0;
    console.log(isChecked);

    fetch(ajaxurl, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded",
      },
      body: new URLSearchParams({
        action: "checkbox_bank",
        checkboxStatus: isChecked,
        id: index + 1, 
      }),
    })
      .then((response) => response.text())
      .then((data) => console.log("Response from server:", data))
      .catch((error) => console.error("Error:", error));
  });
});


 const checkDetals = document.querySelectorAll(".checkDetalClass");
 checkDetals.forEach((item, index) => {
   item.addEventListener("change", function () {
     let isChecked = this.checked ? 1 : 0;
     console.log(isChecked);
     const checkboxId = this.id;
     id = parseInt(checkboxId.slice(10));
     fetch(ajaxurl, {
       method: "POST",
       headers: {
         "Content-Type": "application/x-www-form-urlencoded",
       },
       body: new URLSearchParams({
         action: "checkbox_detal",
         checkboxStatus: isChecked,
         id: id, 
       }),
     })
       .then((response) => response.text())
       .then((data) => console.log("Response from server:", data))
       .catch((error) => console.error("Error:", error));
   });
 });