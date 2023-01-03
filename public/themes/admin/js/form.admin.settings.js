function submitRowAsForm(idRow) {
  form = document.createElement("form");
  form.method = "post";
  form.action = ""; // TELL THE FORM WHAT PAGE TO SUBMIT TO
  $("#"+idRow+" td").children().each(function() {
        if(this.type.substring(0,6) == "select") {
            input = document.createElement("input");
            input.type = "hidden";
            input.name = this.name;
            input.value = this.value;
            form.appendChild(input);
        } else {
            $(this).clone().appendTo(form);
        }

    });
  form.submit();
}