// ==========================================
// HOSTEL MANAGEMENT SYSTEM
// MAIN JAVASCRIPT
// ==========================================

const API = "/hostel-management-system/backend";

// ==========================================
// COMMON REQUEST FUNCTION
// ==========================================

async function sendRequest(url, data = null) {
    const options = {
        method: data ? "POST" : "GET",
        credentials: "include",
        headers: {
            "Content-Type": "application/json"
        }
    };

    if (data) {
        options.body = JSON.stringify(data);
    }

    const response = await fetch(url, options);
    const text = await response.text();

    try {
        return JSON.parse(text);
    } catch (error) {
        console.error("Server response:", text);
        throw new Error(
            text || "Server returned an invalid response"
        );
    }
}

// ==========================================
// ADMIN LOGIN
// ==========================================

const loginForm = document.getElementById("loginForm");

if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const emailElement = document.getElementById("email");
        const passwordElement = document.getElementById("password");

        if (!emailElement || !passwordElement) {
            alert("Login fields are missing.");
            return;
        }

        const email = emailElement.value.trim();
        const password = passwordElement.value;

        if (!email || !password) {
            alert("Please enter email and password.");
            return;
        }

        try {
            const result = await sendRequest(
                API + "/auth/login.php",
                {
                    email: email,
                    password: password
                }
            );

            if (result.success) {
                window.location.href = "pages/dashboard.html";
            } else {
                alert(result.message || "Login failed.");
            }

        } catch (error) {
            console.error("Login error:", error);

            alert(
                "Login connection error: " +
                error.message
            );
        }
    });
}

// ==========================================
// STUDENT REGISTRATION
// ==========================================

const studentForm =
    document.getElementById("studentForm");

if (studentForm) {
    studentForm.addEventListener(
        "submit",
        async function (e) {
            e.preventDefault();

            function getValue(id) {
                const element =
                    document.getElementById(id);

                return element
                    ? element.value.trim()
                    : "";
            }

            const data = {
                student_id: getValue("student_id"),
                full_name: getValue("full_name"),
                date_of_birth: getValue("date_of_birth"),
                gender: getValue("gender"),
                email: getValue("email"),
                phone: getValue("phone"),
                course: getValue("course"),
                semester: getValue("semester"),
                guardian_name: getValue("guardian_name"),
                guardian_phone: getValue("guardian_phone"),
                registration_date:
                    getValue("registration_date"),
                status:
                    getValue("status") || "Active"
            };

            try {
                const result = await sendRequest(
                    API + "/students/create.php",
                    data
                );

                alert(
                    result.message ||
                    "Student registration completed."
                );

                if (result.success) {
                    studentForm.reset();
                    loadStudents();
                }

            } catch (error) {
                console.error(
                    "Student registration error:",
                    error
                );

                alert(
                    "Student registration connection error: " +
                    error.message
                );
            }
        }
    );
}

// ==========================================
// LOAD STUDENTS
// ==========================================

async function loadStudents() {
    const table =
        document.querySelector(
            "#studentsTable tbody"
        );

    if (!table) {
        return;
    }

    try {
        const result = await sendRequest(
            API + "/students/read.php"
        );

        table.innerHTML = "";

        if (
            !result.success ||
            !Array.isArray(result.students)
        ) {
            return;
        }

        result.students.forEach(function (student) {
            const row =
                document.createElement("tr");

            row.innerHTML = `
                <td>${student.student_id || ""}</td>
                <td>${student.full_name || ""}</td>
                <td>${student.course || ""}</td>
                <td>${student.semester || ""}</td>
                <td>${student.phone || ""}</td>
            `;

            table.appendChild(row);
        });

    } catch (error) {
        console.error(
            "Student loading error:",
            error
        );
    }
}

loadStudents();

// ==========================================
// ROOM ALLOCATION
// ==========================================

const roomForm =
    document.getElementById(
        "roomAllocationForm"
    );

async function loadRooms() {
    const select =
        document.getElementById("room_number");

    if (!select) {
        return;
    }

    try {
        const result = await sendRequest(
            API + "/rooms/read.php"
        );

        select.innerHTML =
            '<option value="">Select Room</option>';

        if (
            !result.success ||
            !Array.isArray(result.rooms)
        ) {
            return;
        }

        result.rooms.forEach(function (room) {
            const occupied =
                Number(
                    room.occupied_beds ??
                    room.occupied ??
                    0
                );

            const capacity =
                Number(room.capacity || 0);

            if (occupied < capacity) {
                const option =
                    document.createElement("option");

                option.value = room.id;

                option.textContent =
                    "Room " +
                    (room.room_number || room.id) +
                    " - " +
                    (room.room_type || "") +
                    " (" +
                    occupied +
                    "/" +
                    capacity +
                    ")";

                select.appendChild(option);
            }
        });

    } catch (error) {
        console.error(
            "Room loading error:",
            error
        );
    }
}

loadRooms();

if (roomForm) {
    roomForm.addEventListener(
        "submit",
        async function (e) {
            e.preventDefault();

            const studentElement =
                document.getElementById(
                    "student_id"
                );

            const roomElement =
                document.getElementById(
                    "room_number"
                );

            if (!studentElement || !roomElement) {
                alert(
                    "Student ID or Room Number field is missing."
                );
                return;
            }

            const studentId =
                studentElement.value.trim();

            const roomId =
                roomElement.value;

            if (!studentId) {
                alert("Please enter Student ID.");
                return;
            }

            if (!roomId) {
                alert("Please select a room.");
                return;
            }

            const data = {
                student_id: studentId,
                room_id: roomId
            };

            try {
                const result = await sendRequest(
                    API + "/rooms/allocate.php",
                    data
                );

                alert(
                    result.message ||
                    "Room allocation completed."
                );

                if (result.success) {
                    roomForm.reset();

                    closeRoomForm();

                    loadRooms();
                }

            } catch (error) {
                console.error(
                    "Room allocation error:",
                    error
                );

                alert(
                    "Room allocation connection error: " +
                    error.message
                );
            }
        }
    );
}

// ==========================================
// ROOM MODAL
// ==========================================

function openRoomForm() {
    const modal =
        document.getElementById("roomModal");

    if (modal) {
        modal.style.display = "flex";
    }

    loadRooms();
}

function closeRoomForm() {
    const modal =
        document.getElementById("roomModal");

    if (modal) {
        modal.style.display = "none";
    }
}

// ==========================================
// FEE PAYMENT
// ==========================================

const paymentForm =
    document.getElementById("paymentForm");

if (paymentForm) {
    paymentForm.addEventListener(
        "submit",
        async function (e) {
            e.preventDefault();

            function getFormValue(id) {
                const element =
                    document.getElementById(id);

                return element
                    ? element.value.trim()
                    : "";
            }

            const data = {
                student_id:
                    getFormValue("student_id"),

                amount:
                    getFormValue("amount"),

                fee_type:
                    getFormValue("fee_type"),

                payment_date:
                    getFormValue("payment_date") ||
                    new Date()
                        .toISOString()
                        .split("T")[0],

                payment_method:
                    getFormValue("payment_method") ||
                    "Cash",

                status:
                    getFormValue("status") ||
                    "Paid",

                transaction_reference:
                    getFormValue(
                        "transaction_reference"
                    ) || null
            };

            try {
                const result = await sendRequest(
                    API + "/fees/create.php",
                    data
                );

                alert(
                    result.message ||
                    "Fee payment completed."
                );

                if (result.success) {
                    paymentForm.reset();

                    closePaymentForm();

                    loadFees();
                }

            } catch (error) {
                console.error(
                    "Fee payment error:",
                    error
                );

                alert(
                    "Fee payment connection error: " +
                    error.message
                );
            }
        }
    );
}

// ==========================================
// PAYMENT MODAL
// ==========================================

function openPaymentForm() {
    const modal =
        document.getElementById(
            "paymentModal"
        );

    if (modal) {
        modal.style.display = "flex";
    }
}

function closePaymentForm() {
    const modal =
        document.getElementById(
            "paymentModal"
        );

    if (modal) {
        modal.style.display = "none";
    }
}

// ==========================================
// LOAD FEES
// ==========================================

async function loadFees() {
    const table =
        document.querySelector(
            "#feesTable tbody"
        );

    if (!table) {
        return;
    }

    try {
        const result = await sendRequest(
            API + "/fees/read.php"
        );

        table.innerHTML = "";

        if (
            !result.success ||
            !Array.isArray(result.payments)
        ) {
            return;
        }

        result.payments.forEach(function (payment) {
            const row =
                document.createElement("tr");

            row.innerHTML = `
                <td>#PAY${payment.id || ""}</td>
                <td>${payment.full_name || ""}</td>
                <td>${payment.fee_type || ""}</td>
                <td>Rs. ${payment.amount || ""}</td>
                <td>${payment.payment_date || "-"}</td>
                <td>${payment.status || ""}</td>
                <td>
                    <button
                        type="button"
                        class="view-btn">
                        View
                    </button>
                </td>
            `;

            table.appendChild(row);
        });

    } catch (error) {
        console.error(
            "Fee loading error:",
            error
        );
    }
}

loadFees();

// ==========================================
// COMPLAINTS
// ==========================================

const complaintForm =
    document.getElementById(
        "complaintForm"
    );

if (complaintForm) {
    complaintForm.addEventListener(
        "submit",
        async function (e) {
            e.preventDefault();

            function getFormValue(id) {
                const element =
                    document.getElementById(id);

                return element
                    ? element.value.trim()
                    : "";
            }

            const data = {
                student_id:
                    getFormValue("student_id"),

                complaint_title:
                    getFormValue(
                        "complaint_title"
                    ),

                category:
                    getFormValue("category"),

                complaint_description:
                    getFormValue(
                        "complaint_description"
                    )
            };

            try {
                const result = await sendRequest(
                    API + "/complaints/create.php",
                    data
                );

                alert(
                    result.message ||
                    "Complaint submitted."
                );

                if (result.success) {
                    complaintForm.reset();

                    closeComplaintForm();

                    loadComplaints();
                }

            } catch (error) {
                console.error(
                    "Complaint error:",
                    error
                );

                alert(
                    "Complaint connection error: " +
                    error.message
                );
            }
        }
    );
}

// ==========================================
// COMPLAINT MODAL
// ==========================================

function openComplaintForm() {
    const modal =
        document.getElementById(
            "complaintModal"
        );

    if (modal) {
        modal.style.display = "flex";
    }
}

function closeComplaintForm() {
    const modal =
        document.getElementById (
            "complaintModal")}