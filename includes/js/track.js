/* Retrieve tracker code from URL */
function getTrackerCode() {
    let code = new URL(window.location).searchParams.get("id")
    return code
}

/* Return a boolean depending on if it's json */
function isJson(response) {
    try {
        JSON.parse(response);
        return true;
    } catch (e) {
        return false;
    }
}

/* Load logs in DOM */
function loadLogs(logs) {
    let logsElt = document.getElementById("logs")

    logs.forEach(log => {
        trElt = document.createElement("tr")

        tdDateElt = document.createElement("td")
        tdDateElt.textContent = log.clickedAt

        tdIpElt = document.createElement("td")
        tdIpElt.textContent = log.ip

        tdUserAgentElt = document.createElement("td")
        tdUserAgentElt.textContent = log.userAgent

        trElt.appendChild(tdDateElt)
        trElt.appendChild(tdIpElt)
        trElt.appendChild(tdUserAgentElt)

        logsElt.appendChild(trElt)
    })
}


/* Request to GET log of a tracker */
function getLogs() {
    let xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if(isJson(xhr.responseText)) {
                let response = JSON.parse(xhr.responseText)

                if(response.message === "Success") {
                    loadLogs(response.response);
                } else if(response.message === "Invalid tracker") {
                    window.location.href = "404.php";
                } else if(response.message === "No logs found") {
                    let errorMessageElt = document.createElement("span")
                    errorMessageElt.textContent = response.message
                    document.body.appendChild(errorMessageElt)
                } else {
                    alert("Server Error");
                }
            } else {
                alert("Server Error");
            }
        }
    }
    xhr.open('GET', 'api/tracker/get.php?tracker=' + getTrackerCode() + '&_=' + new Date().getTime(), true) // Removing cache with Date().getTime()
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest')
    xhr.send()
}

getLogs();
