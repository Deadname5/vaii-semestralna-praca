import {DataService} from "./DataService.js";



class TeacherForm extends DataService {
    constructor() {
        super("teacherApi");
        /*TODO do form errors client side, async form saving*/
        try {
            document.getElementById("btn-teacher").onclick = async (me) => {
                document.getElementById("btn-teacher").disabled = true;
                me.preventDefault();
                try {
                    while (true) {
                        document.getElementById("serverError").remove();
                    }
                } catch (error) {

                }

                document.getElementById("errors").innerHTML = "";

                let teacher = 0;
                try {
                    teacher = document.getElementById("id").value;
                } catch (error) {

                }
                let user = 0;
                try {
                    user = document.getElementById("uid").value;
                } catch (error) {

                }

                let name = document.getElementById("name").value;
                let surname = document.getElementById("surname").value;
                let language = document.getElementById("language").value;
                let username = document.getElementById("login").value;
                let password = document.getElementById("password").value;

                let errorStrings = [];

                if (name.trim() === "") {
                    errorStrings.push("Pole meno musi byt vyplnene!");
                }

                if (surname.trim() === "") {
                    errorStrings.push("Pole priezvisko musi byt vyplnene!");
                }

                if (language.trim() === "") {
                    errorStrings.push("Pole vyucovaci jazyk musi byt vyplnene!");
                }

                if (username.trim() === "") {
                    errorStrings.push("Pole login musi byt vyplnene!");
                }

                if (password.trim() === "") {
                    errorStrings.push("Pole heslo musi byt vyplnene!");
                }

                if (language !== "" && (language.replace(/\s/g, '').length !== 3 || language.length !== 3)) {
                    errorStrings.push("Vyucovaci jazyk sa musi skladat z troch pismen bez medzier!");
                }

                if (username !== "") {
                    if (username.indexOf(' ') !== -1) {

                        errorStrings.push("Login nesmie obsahovat ziadne medzery!");
                    } else
                    {
                        let usernameExists = await this.findUser(username.trim(), teacher);
                        if (usernameExists) {
                            errorStrings.push("Takyto login uz existuje!");
                        }
                    }
                }

                if (password !== "" && password.indexOf(' ') !== -1) {
                    errorStrings.push("Heslo nesmie obsahovat ziadne medzery!");
                }

                if (password !== "" && password.length < 6) {
                    errorStrings.push("Heslo musi mat aspon 6 znakov!");
                }

                if (errorStrings.length !== 0) {
                    let err = document.getElementById("errors");
                    errorStrings.forEach((error) => {
                        let stringHTML = `<div class="alert alert-danger">${error}</div>`;
                        err.innerHTML = err.innerHTML + stringHTML;
                    });
                    document.getElementById("btn-teacher").disabled = false;
                } else {
                    let save = await this.save(teacher, user, name, surname, language, username, password);
                    if (save !== false) {
                        if (save.formErrors === null)
                        {
                            let success = document.getElementById("success");
                            success.innerHTML = `<div class="alert alert-success">Teacher was saved! Returning...</div>`;
                            setTimeout(() => {window.location.href = "http://localhost/?c=teacher&a=index"}, 3000);
                        } else {
                            let err = document.getElementById("errors");
                            save.formErrors.forEach((error) => {
                                let stringHTML = `<div class="alert alert-danger">${error}</div>`;
                                err.innerHTML = err.innerHTML + stringHTML;
                            });
                            document.getElementById("btn-teacher").disabled = true;
                        }
                    }
                }



            }
        } catch (error) {}
    }


    async findUser(username, teacher) {
        return await this.sendRequest(
            "findUser",
            "POST",
            204,
            {
                'username': username,
                'teacher': teacher
            },
            false
        );


    }

    async save(teacher, user, name, surname, language, username, password){
        return await this.sendRequest(
            "save",
            "POST",
            200,
            {
                'teacher': teacher,
                'user': user,
                'name': name,
                'surname': surname,
                'language': language,
                'username': username,
                'password': password

            },
            false

        );
    }






}

export {TeacherForm};