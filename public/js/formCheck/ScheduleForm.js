import {DataService} from "./DataService.js";


class ScheduleForm extends DataService {
    constructor() {
        super("scheduleApi");

        try {
            document.getElementById("btn-schedule").onclick = async (me) => {
                me.preventDefault();
                document.getElementById("btn-schedule").disabled = true;

                try {
                    while (true) {
                        document.getElementById("serverError").remove();
                    }
                } catch (error) {

                }

                document.getElementById("errors").innerHTML = "";
                let schedule = 0;
                try {
                    schedule = document.getElementById("id").value;
                } catch (error) {

                }

                let admin = await this.isAdmin();
                let student = document.getElementById("student").value;
                let teacher = document.getElementById("teacher").value;
                let start = document.getElementById("start").value;
                let end = document.getElementById("end").value;

                let errorStrings = [];

                if (!student) {
                    errorStrings.push("Pole student musi byt vyplnene!");
                }

                if (admin) {
                    if (!teacher) {
                        errorStrings.push("Pole ucitel musi byt vyplnene!");
                    }
                }

                if (!start) {
                    errorStrings.push("Pole zaciatok musi byt vyplnene!");
                }

                if (start && end && end < start) {
                    errorStrings.push("Koniec vyucby musi byt neskor ako zaciatok vyucby!");
                }

                if (errorStrings.length !== 0) {
                    let err = document.getElementById("errors");
                    errorStrings.forEach((error) => {
                        let stringHTML = `<div class="alert alert-danger">${error}</div>`;
                        err.innerHTML = err.innerHTML + stringHTML;
                    });
                    document.getElementById("btn-schedule").disabled = false;
                } else {
                    let save = await this.save(schedule, student, teacher, start, end);
                    if (save !== false) {
                        if (save.formErrors === null)
                        {
                            let success = document.getElementById("success");
                            success.innerHTML = `<div class="alert alert-success">Schedule was saved! Returning...</div>`;
                            setTimeout(() => {window.location.href = "http://localhost/?c=schedule&a=index"}, 3000);
                        } else {
                            let err = document.getElementById("errors");
                            save.formErrors.forEach((error) => {
                                let stringHTML = `<div class="alert alert-danger">${error}</div>`;
                                err.innerHTML = err.innerHTML + stringHTML;
                            });
                            document.getElementById("btn-schedule").disabled = false;
                        }
                    }
                }

            }
        } catch (error) {

        }



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

    async save(schedule, student, teacher, start, end){
        return await this.sendRequest(
            "save",
            "POST",
            200,
            {
                'schedule': schedule,
                'student': student,
                'teacher': teacher,
                'start': start,
                'end': end

            },
            false

        );
    }



}



export {ScheduleForm}