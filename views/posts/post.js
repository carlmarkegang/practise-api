function deletePost(mainpost, subpost) {
    if (confirm("Are you sure you want to delete this post?") == true) {
        window.location.replace('index.php?controller=posts&action=deletepost&parent=' + mainpost + '&id=' + subpost);
    }
}

function editPost(element) {
    element.parentElement.parentElement.getElementsByClassName("subpoststext")[0].style.display = "none";
    element.parentElement.parentElement.getElementsByClassName("subpostsedittext")[0].style.display = "block";
}

function cancelEditPost(element) {
    element.parentElement.parentElement.getElementsByClassName("subpoststext")[0].style.display = "block";
    element.parentElement.parentElement.getElementsByClassName("subpostsedittext")[0].style.display = "none";
}