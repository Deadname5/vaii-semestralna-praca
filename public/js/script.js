import {StudentForm} from "./formCheck/StudentForm.js";
import {deletePopUp} from "./deletePopUp.js";
import {ScheduleForm} from "./formCheck/ScheduleForm.js";
import {TeacherForm} from "./formCheck/TeacherForm.js";
import {ScheduleStudentInfo} from "./ScheduleStudentInfo.js";

document.formStudent = new StudentForm();
document.deletePopUp = new deletePopUp();
document.formSchedule = new ScheduleForm();
document.formTeacher = new TeacherForm();
document.studentInfo = new ScheduleStudentInfo();



