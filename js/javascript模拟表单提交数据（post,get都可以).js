function post(URL, name, password) {
    let temp_form = document.createElement("form");
    temp_form.action = URL;
    temp_form.target = "_blank";
    temp_form.method = "post";
    temp_form.style.display = "none";
    let opt1 = document.createElement("input");
    let opt2 = document.createElement("input");
    opt1.name = "name";
    opt1.value = name;
    opt2.name = "password";
    opt2.value = password;
    temp_form.appendChild(opt1);
    temp_form.appendChild(opt2);
    document.body.appendChild(temp_form);
    temp_form.submit();
}