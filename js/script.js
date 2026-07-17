// Student Registration

document.getElementById("studentForm").addEventListener("submit", function (e) {

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

    fetch("http://localhost/hostel-management-system/backend/students/create.php", {

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

            document.getElementById("studentForm").reset();

        }

    })

    .catch(error => {

        console.error(error);

        alert("Error connecting to backend.");

    });

});
// Load Students

function loadStudents() {

    fetch("http://localhost/hostel-management-system/backend/students/read.php")

    .then(response => response.json())

    .then(data => {

        let table = document.querySelector("#studentsTable tbody");

        table.innerHTML = "";

        data.students.forEach(student => {

            table.innerHTML += `
                <tr>
                    <td>${student.student_id}</td>
                    <td>${student.full_name}</td>
                    <td>${student.course}</td>
                    <td>${student.semester}</td>
                    <td>${student.phone}</td>
                </tr>
            `;

        });

    });

}

// Run when page opens
loadStudents();