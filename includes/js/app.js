/* Return a boolean depending on if it's json */
function isJson(response) {
    try {
        JSON.parse(response);
        return true;
    } catch (e) {
        return false;
    }
}

/* Request to create iplogger */
function createIpLogger(e) {
    e.preventDefault()
    let url = document.getElementById("url").value

    let xhr = new XMLHttpRequest()
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            formElt.reset()
            
            if(isJson(xhr.responseText)) {
                let response = JSON.parse(xhr.responseText)

                if(response.message === "Success") {
                    document.getElementById("result").innerHTML = "Your Link Logger is : <a target='_blank' href='" + document.URL.substr(0, document.URL.lastIndexOf('/')) + "/link.php?id=" + response.response.shortUrlCode + "'>" + document.URL.substr(0, document.URL.lastIndexOf('/')) + "/link.php?id=" + response.response.shortUrlCode  + "</a><br />Your Tracker Link is : <a target='_blank' href='" + document.URL.substr(0, document.URL.lastIndexOf('/')) + "/tracker.php?id=" + response.response.trackerCode + "'>" + document.URL.substr(0, document.URL.lastIndexOf('/')) + "/tracker.php?id=" + response.response.trackerCode + "</a><br /><br /><span style='color:red;'>Please take note because you won't be able to do it after</span>"
                } else if(response.message === "Please complete all fields") {
                    alert(response.message)
                } else if(response.message === "Invalid URL") {
                    alert(response.message)
                } else if(response.message === "Unable to create tracker") {
                    alert(response.message)
                } else if(response.message === "Unable to create short url") {
                    alert(response.message)
                } else {
                    alert("Server Error")
                }
            } else {
                alert("Server Error")
            }
        }
    }
    xhr.open("POST", "api/iplogger.php")
    xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest")
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8")
    xhr.send("url="+url)
}

let formElt = document.getElementById("form")
    
formElt.addEventListener("submit", function(e) {
    createIpLogger(e)
})
