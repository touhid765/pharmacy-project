// List of pharmacists and their timetables
const pharmacists = {
    "pharmacist1": {
        "password": "pass1",
        "timetable": "Monday - Friday: 9 AM - 5 PM",
        "attendance": false
    },
    "pharmacist2": {
        "password": "pass2",
        "timetable": "Monday - Friday: 10 AM - 6 PM",
        "attendance": false
    },
    "pharmacist3": {
        "password": "pass3",
        "timetable": "Tuesday - Saturday: 8 AM - 4 PM",
        "attendance": false
    },
    "pharmacist4": {
        "password": "pass4",
        "timetable": "Wednesday - Sunday: 11 AM - 7 PM",
        "attendance": false
    },
    "admin": {
        "password": "adminpass",
        "timetable": "Admin has no timetable.",
        "attendance": false
    }
};

// Handle login
document.getElementById('loginForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (pharmacists[username] && pharmacists[username].password === password) {
        document.getElementById('timetableSection').style.display = 'block';
        document.getElementById('timetable').textContent = `Hello, ${username}. Your timetable: ${pharmacists[username].timetable}`;
        document.getElementById('attendanceSection').style.display = 'block';
    } else {
        alert("Invalid username or password!");
    }
});

// Handle attendance
document.getElementById('markAttendanceBtn').addEventListener('click', function () {
    const username = document.getElementById('username').value;
    pharmacists[username].attendance = true;
    document.getElementById('attendanceStatus').textContent = "Attendance marked for today!";
});

// Handle pharmacist registration (admin only)
document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const newUsername = document.getElementById('newUsername').value;
    const newPassword = document.getElementById('newPassword').value;
    const newTimetable = document.getElementById('newTimetable').value;
    
    // Check if admin is logged in
    const loggedInUser = document.getElementById('username').value;
    if (loggedInUser !== "admin") {
        alert("Only admin can register new pharmacists.");
        return;
    }

    // Register the new pharmacist
    pharmacists[newUsername] = {
        password: newPassword,
        timetable: newTimetable,
        attendance: false
    };

    document.getElementById('registrationSuccess').style.display = 'block';
    document.getElementById('registerForm').reset();
});

