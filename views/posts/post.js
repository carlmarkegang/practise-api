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

function checkTextInput(element) {

    if (document.getElementById("text").value == "") {
        document.getElementById("plzwritediv").style.display = "block";
        return false;
    }
    return true;
}

function loadMorePosts(parent,offset,offsetStatic) {
    if (window.XMLHttpRequest) {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (this.readyState==4 && this.status==200) {
            if(this.responseText == ""){
                document.getElementById("loadmoreposts").style.display = "none";
            }
            offset+=offsetStatic;
            document.getElementById("mainpostswrap").innerHTML+=this.responseText;
            document.getElementById("loadmoreposts").setAttribute("onclick", "loadMorePosts(" + parent + ","+ offset + ","+ offsetStatic +")");
        }
    }
    xmlhttp.open("GET","views/posts/include/loadPost.php?parent="+ parent +"&offset="+offset +"&offsetstatic="+offsetStatic,true);
    xmlhttp.send();
}