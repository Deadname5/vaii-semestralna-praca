import {DataService} from "./formCheck/DataService.js";

class ScheduleInfo extends DataService {
    constructor() {
        super("scheduleApi");
    }

    async getInfo(id) {
        let info = "info" + id;
        try {
            let infoHTML = document.getElementById(info);
            if (infoHTML.innerHTML === "") {
                let student = await this.getStudent(id);
                if (student !== null) {
                    let name = student.name;
                    let surname = student.surname;
                    infoHTML.innerHTML += `<div class="col-12 col-md-3">
                                            <h2>Meno: ${name}</h2>
                                            </div>`;
                    infoHTML.innerHTML += `<div class="col-12 col-md-3">
                                            <h2>Prizevisko: ${surname}</h2>
                                            </div>`;
                }
            } else {
                infoHTML.innerHTML = "";
            }

            let check = await this.isAdmin();
            if (check === true) {
                try {
                    let teach = "teach" + id;
                    let teachHTML = document.getElementById(teach);
                    let teacher = await this.getTeacher(id);
                    if (teach !== null) {
                        let name = teacher.name;
                        let surname = teacher.surname;
                        try {
                            let teachName = document.getElementById("teachName" + id);
                            teachName.remove();
                        } catch (error) {
                            teachHTML.innerHTML += `<div id="teachName${id}" class="col-12 col-md-3">
                                                <h2>Meno: ${name}</h2>
                                                </div>`;
                        }

                        try {
                            let teachSurname = document.getElementById("teachSurname" + id);
                            teachSurname.remove();
                        } catch (error) {
                            teachHTML.innerHTML += `<div id="teachSurname${id}" class="col-12 col-md-3">
                                                <h2>Prizevisko: ${surname}</h2>
                                                </div>`;
                        }
                    }
                } catch (error) {

                }
            }
        } catch (error) {

        }


    }

    async getStudent(id) {
        return await this.sendRequest(
            "getStudent",
            "POST",
            200,
            {
                'id': id
            },
            null
        );
    }

    async getTeacher(id) {
        return await this.sendRequest(
            "getTeacher",
            "POST",
            200,
            {
                'id': id
            },
            null
        );
    }

    async isAdmin() {
        return await this.sendRequest(
            "isAdmin",
            "POST",
            204,
            null,
            false

        );
    }
}

export {ScheduleInfo}