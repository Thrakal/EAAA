async function search(searchString) {
    let response = await fetch("api/search.php?query=" + searchString);

    let data = await response.json();
    document.querySelector("#searchResult").innerHTML = "";

    if(data.status == "success") {
        for (const user of data.data) {
            document.querySelector("#searchResult").innerHTML += user.name + "<br>";
        }
    } else {
        document.querySelector("#searchResult").innerHTML += data.message;
    }
}


async function authUser() {
    const userData = {
        id: 8,
        name: "Kasper Topp",
        age: 34,
        isAwesome: true
    }

    let response = await fetch("api/auth.php", 
    {
        method: "POST",
        body: JSON.stringify(userData)
    }
    );

    let data = await response.json();

    if(data.status == "success") {
        localStorage.setItem('userToken', data.data.token);
    }

    document.querySelector("#jsonResponse").innerHTML = data.message;
}


async function userGetData() {
    let response = await fetch("api/user.php", 
    {
        method: "POST",
        headers: {
            'Authentication': localStorage.getItem('userToken')
        }
    }
    );

    let data = await response.json();

    document.querySelector("#jsonResponse").innerHTML = data.message;
}


function userLogout() {
    localStorage.removeItem("userToken");
    document.querySelector("#jsonResponse").innerHTML = "User logged out";
}