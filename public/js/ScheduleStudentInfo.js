import {DataService} from "./formCheck/DataService.js";

class ScheduleStudentInfo extends DataService {
    constructor() {
        super("scheduleApi");
    }

    async getStudentInfo(id) {
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
}

export {ScheduleStudentInfo}