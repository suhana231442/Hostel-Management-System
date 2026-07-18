// ===============================
// ADMIN LOGIN
// ===============================

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function (event) {

        event.preventDefault();

        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        fetch("auth/login.php", {
            credentials: "include",

            method: "POST",

            headers: {
                "Content-Type": "application/json"
            },

            body: JSON.stringify({
                email: email,
                password: password
            })

        })

        .then(response => response.json())

        .then(result => {

            if (result.success) {

                window.location.href = "pages/dashboard.html";

            } else {

                alert(result.message);

            }

        })

        .catch(error => {

            console.error(error);

            alert("Error connecting to backend.");

        });

    });

}


// ===============================
// STUDENT REGISTRATION
// ===============================

const studentForm = document.getElementById("studentForm");

if (studentForm) {

    studentForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const data = {

            student_id: document.getElementById("student_id").value,

            full_name: document.getElementById("full_name").value,

            date_of_birth: document.getElementById("date_of_birth").value,

            gender: document.getElementById("gender").value,

            email: document.getElementById("email").value,

            phone: document.getElementById("phone").value,

            course: document.getElementById("course").value,

            semester: document.getElementById("semester").value,

            guardian_name: document.getElementById("guardian_name").value,

            guardian_phone: document.getElementById("guardian_phone").value,

            registration_date: document.getElementById("registration_date").value,

            status: document.getElementById("status").value

        };

        fetch("../students/create.php", {

            method: "POST",

            headers: {

                "Content-Type": "application/json"

            },

            body: JSON.stringify(data)

        })

        .then(response => response.json())

        .then(result => {

            alert(result.message);

            if (result.success) {

                studentForm.reset();

            }

        })

        .catch(error => {

            console.error(error);

            alert("Error connecting to backend.");

        });

    });

}


// ===============================
// LOAD STUDENTS
// ===============================

function loadStudents() {

    const studentsTable = document.querySelector("#studentsTable tbody");

    if (!studentsTable) {

        return;

    }

    fetch("../students/read.php")

        .then(response => response.json())

        .then(data => {

            studentsTable.innerHTML = "";

            data.students.forEach(student => {

                studentsTable.innerHTML += `

                    <tr>

                        <td>${student.student_id}</td>

                        <td>${student.full_name}</td>

                        <td>${student.course}</td>

                        <td>${student.semester}</td>

                        <td>${student.phone}</td>

                    </tr>

                `;

            });

        })

        .catch(error => {

            console.error("Error loading students:", error);

        });

}


// Run student loading only when needed

loadStudents();
// ===============================
// DASHBOARD DATA
// ===============================

function loadDashboardData() {

    const totalStudents = document.getElementById("totalStudents");

    if (!totalStudents) {

        return;

    }

        fetch("../dashboard/dashboard_data.php", {
            credentials: "include"
    })

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                document.getElementById("totalStudents").textContent =
                    data.total_students;

                document.getElementById("totalRooms").textContent =
                    data.total_rooms;

                document.getElementById("pendingFees").textContent =
                    data.pending_fees;

                document.getElementById("pendingComplaints").textContent =
                    data.pending_complaints;

            }

        })

        .catch(error => {

            console.error("Error loading dashboard data:", error);

        });

}


