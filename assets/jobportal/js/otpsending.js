let isProcessing = false; // ✅ global flag

function sendOtpAjax(e, el) {
    alert("hello");
    e.preventDefault();

    if (isProcessing) {
        return false; // ❌ already running
    }

    isProcessing = true;

    let redirectUrl = el.getAttribute("href");

    // ✅ disable click UI
    el.style.pointerEvents = "none";
    el.style.opacity = "0.6";
     el.innerHTML = "Sending OTP..."; 
    $.ajax({
        url: FetchSendMail,
        type: "POST",
        dataType: "json",
        data: {
            uid: sessionUid
        },
        success: function (res) {

            if (res.status === 'success') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: res.msg,
                    showConfirmButton: false,
                    timer: 1000
                });
            } else {
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: res.msg,
                    showConfirmButton: false,
                    timer: 1000
                });
            }

            setTimeout(function () {
                window.location.href = redirectUrl;
            }, 1000);
        },
        error: function () {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'Something went wrong ❌',
                showConfirmButton: false,
                timer: 1000
            });

            setTimeout(function () {
                window.location.href = redirectUrl;
            }, 1000);
        }
    });

    // ❗ 5 sec nantar parat enable (optional fallback)
    setTimeout(function () {
        isProcessing = false;
        el.style.pointerEvents = "auto";
        el.style.opacity = "1";
    }, 5000);

    return false;
}
