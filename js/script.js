const API = "..";

// =====================================================
// COMMON POST FUNCTION
// =====================================================

function postJSON(url, data) {
    return fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        credentials: "include",
        body: JSON.stringify(data)
    }).then(async function (response) {
        const text = await response.text();

        try {
            return JSON.parse(text);
        } catch (e) {
            throw new Error(text || "Server error");
        }
    });
}


// =====================================================
// LOGIN
// =====================================================

const loginForm = document.getElementById("loginForm");

if (loginForm) {

    loginForm.addEventListener("submit", function (e) {

        e.preventDefault();

        postJSON("../auth/login.php", {
            email: document.getElementById("email").value,
            password: document.getElementById("password").value
        })
        .then(function (r) {

            if (r.success) {
                location.href = "pages/dashboard.html";
            } else {
                alert(r.message);
            }

        })
        .catch(function (e) {
            alert("Login error: " + e.message);
        });

    });
}


// =====================================================
// STUDENTS
// =====================================================

const studentForm = document.getElementById("studentForm");

function loadStudents() {

    const tbody = document.querySelector("#studentsTable tbody");

    if (!tbody) {
        return;
    }

    fetch("../students/read.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        tbody.innerHTML = "";

        (d.students || []).forEach(function (s) {

            tbody.innerHTML +=
                "<tr>" +
                "<td>" + (s.student_id || "") + "</td>" +
                "<td>" + (s.full_name || "") + "</td>" +
                "<td>" + (s.course || "") + "</td>" +
                "<td>" + (s.semester || "") + "</td>" +
                "<td>" + (s.phone || "") + "</td>" +
                "</tr>";

        });

    })
    .catch(function (e) {
        console.log("Student loading error:", e);
    });
}


if (studentForm) {

    studentForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const ids = [
            "student_id",
            "full_name",
            "date_of_birth",
            "gender",
            "email",
            "phone",
            "course",
            "semester",
            "guardian_name",
            "guardian_phone",
            "registration_date",
            "status"
        ];

        const data = {};

        ids.forEach(function (id) {

            const element = document.getElementById(id);

            data[id] = element ? element.value : "";

        });

        postJSON("../students/create.php", data)

        .then(function (r) {

            alert(r.message);

            if (r.success) {

                studentForm.reset();

                loadStudents();

            }

        })

        .catch(function (e) {

            alert("Registration error: " + e.message);

        });

    });

    loadStudents();
}


// =====================================================
// ROOMS
// =====================================================

function loadRooms() {

    const sel = document.getElementById("room_number");

    if (!sel) {
        return;
    }

    fetch("../rooms/read.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        sel.innerHTML =
            '<option value="">Select a room</option>';

        (d.rooms || []).forEach(function (x) {

            if (
                Number(x.occupied_beds) <
                Number(x.capacity)
            ) {

                sel.innerHTML +=
                    '<option value="' +
                    x.id +
                    '">' +
                    "Room " +
                    x.room_number +
                    " (" +
                    x.occupied_beds +
                    "/" +
                    x.capacity +
                    ")" +
                    "</option>";

            }

        });

    })
    .catch(function (e) {
        console.log("Room loading error:", e);
    });
}


const roomForm =
    document.getElementById("roomAllocationForm");

if (roomForm) {

    roomForm.addEventListener("submit", function (e) {

        e.preventDefault();

        postJSON("../rooms/allocate.php", {

            student_id:
                document.getElementById("student_id").value.trim(),

            room_id:
                document.getElementById("room_number").value

        })
        .then(function (r) {

            alert(r.message);

            if (r.success) {

                roomForm.reset();

                closeRoomForm();

                loadRooms();

            }

        })
        .catch(function (e) {

            alert("Room error: " + e.message);

        });

    });

    loadRooms();
}


function openRoomForm() {

    const x = document.getElementById("roomModal");

    if (x) {
        x.style.display = "flex";
    }
}


function closeRoomForm() {

    const x = document.getElementById("roomModal");

    if (x) {
        x.style.display = "none";
    }
}


// =====================================================
// FEES
// =====================================================

const paymentForm =
    document.getElementById("paymentForm");

if (paymentForm) {

    paymentForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const inputs =
            paymentForm.querySelectorAll("input");

        const select =
            paymentForm.querySelector("select");

        postJSON("../fees/create.php", {

            student_id:
                inputs[1].value.trim(),

            amount:
                inputs[2].value,

            fee_type:
                select.value,

            payment_date:
                inputs[3].value,

            payment_method:
                "Cash",

            status:
                "Paid",

            transaction_reference:
                ""

        })
        .then(function (r) {

            alert(r.message);

            if (r.success) {

                paymentForm.reset();

                closePaymentForm();

                loadFees();

            }

        })
        .catch(function (e) {

            alert("Payment error: " + e.message);

        });

    });
}


function closePaymentForm() {

    const x =
        document.getElementById("paymentModal");

    if (x) {
        x.style.display = "none";
    }
}


function openPaymentForm() {

    const x =
        document.getElementById("paymentModal");

    if (x) {
        x.style.display = "flex";
    }
}


function loadFees() {

    const table =
        document.querySelector("#feesTable tbody");

    if (!table) {
        return;
    }

    fetch("../fees/read.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        table.innerHTML = "";

        (d.payments || []).forEach(function (p) {

            table.innerHTML +=
                "<tr>" +
                "<td>" + (p.full_name || "") + "</td>" +
                "<td>" + (p.amount || "") + "</td>" +
                "<td>" + (p.fee_type || "") + "</td>" +
                "<td>" + (p.payment_date || "") + "</td>" +
                "<td>" + (p.status || "") + "</td>" +
                "</tr>";

        });

    })
    .catch(function () {});
}

loadFees();


// =====================================================
// COMPLAINTS
// =====================================================

const complaintForm =
    document.getElementById("complaintForm");

if (complaintForm) {

    complaintForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const inputs =
            complaintForm.querySelectorAll("input");

        const sel =
            complaintForm.querySelector("select");

        const ta =
            complaintForm.querySelector("textarea");

        postJSON("../complaints/create.php", {

            student_id:
                inputs[1].value.trim(),

            complaint_title:
                inputs[2].value.trim(),

            complaint_description:
                ta.value,

            category:
                sel.value

        })
        .then(function (r) {

            alert(r.message);

            if (r.success) {

                complaintForm.reset();

                closeComplaintForm();

                loadComplaints();

            }

        })
        .catch(function (e) {

            alert("Complaint error: " + e.message);

        });

    });
}


function closeComplaintForm() {

    const x =
        document.getElementById("complaintModal");

    if (x) {
        x.style.display = "none";
    }
}


function openComplaintForm() {

    const x =
        document.getElementById("complaintModal");

    if (x) {
        x.style.display = "flex";
    }
}


function loadComplaints() {

    const table =
        document.querySelector("#complaintsTable tbody");

    if (!table) {
        return;
    }

    fetch("../complaints/read.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        table.innerHTML = "";

        (d.complaints || []).forEach(function (c) {

            table.innerHTML +=
                "<tr>" +
                "<td>" + (c.full_name || "") + "</td>" +
                "<td>" + (c.complaint_title || "") + "</td>" +
                "<td>" + (c.category || "") + "</td>" +
                "<td>" + (c.status || "") + "</td>" +
                "</tr>";

        });

    })
    .catch(function () {});
}

loadComplaints();


// =====================================================
// NOTICES
// =====================================================

const noticeForm =
    document.getElementById("noticeForm");

if (noticeForm) {

    noticeForm.addEventListener("submit", function (e) {

        e.preventDefault();

        const inp =
            noticeForm.querySelector("input");

        const sels =
            noticeForm.querySelectorAll("select");

        const ta =
            noticeForm.querySelector("textarea");

        postJSON("../notices/create.php", {

            title:
                inp.value.trim(),

            description:
                ta.value,

            category:
                sels[0].value,

            notice_type:
                "General",

            priority:
                sels[1].value,

            expiry_date:
                null,

            status:
                "Active"

        })
        .then(function (r) {

            alert(r.message);

            if (r.success) {

                noticeForm.reset();

                closeNoticeForm();

                loadNotices();

            }

        })
        .catch(function (e) {

            alert("Notice error: " + e.message);

        });

    });
}


function closeNoticeForm() {

    const x =
        document.getElementById("noticeModal");

    if (x) {
        x.style.display = "none";
    }
}


function openNoticeForm() {

    const x =
        document.getElementById("noticeModal");

    if (x) {
        x.style.display = "flex";
    }
}


function loadNotices() {

    const box =
        document.querySelector("#noticesTable tbody");

    if (!box) {
        return;
    }

    fetch("../notices/read.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        box.innerHTML = "";

        (d.notices || []).forEach(function (n) {

            box.innerHTML +=
                "<tr>" +
                "<td>" + (n.title || "") + "</td>" +
                "<td>" + (n.category || "") + "</td>" +
                "<td>" + (n.priority || "") + "</td>" +
                "<td>" + (n.status || "") + "</td>" +
                "</tr>";

        });

    })
    .catch(function () {});
}

loadNotices();


// =====================================================
// DASHBOARD
// =====================================================

function loadDashboardData() {

    const el =
        document.getElementById("totalStudents");

    if (!el) {
        return;
    }

    fetch("../dashboard/dashboard_data.php", {
        credentials: "include"
    })
    .then(function (r) {
        return r.json();
    })
    .then(function (d) {

        if (d.success) {

            el.textContent =
                d.total_students;

            const rooms =
                document.getElementById("totalRooms");

            if (rooms) {
                rooms.textContent =
                    d.total_rooms;
            }

            const fees =
                document.getElementById("pendingFees");

            if (fees) {
                fees.textContent =
                    d.pending_fees;
            }

            const complaints =
                document.getElementById("pendingComplaints");

            if (complaints) {
                complaints.textContent =
                    d.pending_complaints;
            }

        }

    })
    .catch(function (e) {

        console.log(
            "Dashboard:",
            e
        );

    });
}

loadDashboardData();