import {DataService} from "./DataService.js";


class StudentForm extends DataService {
    constructor() {
        super("student");

        try {
            document.getElementById("btn-student").onclick = (me) => {
                try {
                    while (true) {
                        document.getElementById("serverError").remove();
                    }
                } catch (error) {

                }

                document.getElementById("errors").innerHTML = "";


                let name = document.getElementById("name").value;
                let surname = document.getElementById("surname").value;

                let errorStrings = [];

                if (name.trim() === "") {
                    errorStrings.push("Pole meno musi byt vyplnene!");
                }

                if (surname.trim() === "") {
                    errorStrings.push("Pole priezvisko musi byt vyplnene!");
                }

                if (errorStrings.length !== 0) {
                    let err = document.getElementById("errors");
                    errorStrings.forEach((error) => {
                        let stringHTML = `<div class="alert alert-danger">${error}</div>`;
                        err.innerHTML = err.innerHTML + stringHTML;
                    });
                    me.preventDefault();
                }
            }
        } catch (error) {

        }



    }



}



export {StudentForm}