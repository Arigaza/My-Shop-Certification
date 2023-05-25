/***
 * MyShopUI interface de démarrage
 * Dispatch vers le controller ad hoc
 *
 * MyShopUI Application
 *
 * @package    MyShopUI
 * @author     Kevin Fabre
 * @email      ariga@hotmail.fr
 * @copyright  Ariga 2023
 * @license    https://www.gnu.org/licenses/gpl-3.0.en.html  GNU General Public License
 * @version    1.0.0
 ***/

'use strict';
docReady(() => {

    const d = document;
    const modal = d.querySelector('.modal');
    const modalBtn = d.querySelector('#modalBtn');
    const navloginBtn = d.querySelector('#navloginBtn');
    const span = d.getElementsByClassName("close")[0];
    const loginBtn = d.querySelector('#loginBtn');
    const logoutBtn = d.querySelector('#logout');
    const passwordConfirm = d.querySelector('#password_confirm');
    const password = d.querySelector('#password');
    const form = d.querySelector('#loginContainer');
    const nom = d.querySelector('#name');
    const prenom = d.querySelector('#surname');
    const description = d.querySelector('#description');
    const itemID = d.querySelector('#itemID');
    const instagramName = d.querySelector('#instagramName');
    const instagramAddress = d.querySelector('#instagramAddress');
    const tabname = d.querySelector('#tabName');
    const deleteImagePath = d.querySelector('#delete_image_path')
    const registerBtn = d.querySelector('#registerBtn');
    const InfiniteScroll = document.querySelector('#Gallery_container');
    const CSRF = d.querySelector('meta[name="csrf-token"]').content;
    const login = d.querySelector('#email');
    const CSRFPost = d.querySelector('#MYSHOP_CSRF_TOKEN_SESS_IDX');
    const deleteBtn = d.querySelector('#deleteBtn')
    const homeImageIDSelector = d.querySelector('#homeImageIDSelector')
    const afterheader = d.querySelector('.afterheader ')
    const ajaxHeaders = {
        'credentials': 'same-origin',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': CSRF,
        'cache': 'no-cache',
        'Cache-Control': 'no-store, no-transform, max-age=0, private',
        'Content-Type': 'application/json'
    };
    const ajaxHeadersGet = {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': CSRF,
        'cache': 'no-cache',
        'Cache-Control': 'no-store, no-transform, max-age=0, private',
        'Content-Type': 'application/json',
    };
    //  dropdown management
    let dropdownToggle = d.querySelector('#homedropdowntoggle');
    let dropdown = d.querySelector('#dropdown');

    // check if there is homepageImage & change background color of header
    let homePageImage = d.querySelector('#frontpageimage');
    let homePageImageContainer = d.querySelector('#frontpagecontainer');
    let headersSelector = d.querySelectorAll('.nav-item');
    let headerSelectorAdmin = d.querySelector('#header_admin')
    let logoSelector = d.querySelectorAll('.logohomepage')
    let postHImageWhite = d.querySelectorAll('.change_color_white')
    // update collection ID selector
    let collectionSelector = d.querySelector('#collection-selector');
    let collectionId = d.querySelector('#collections_id');

    // update collection name selector
    let subCollectionSelector = d.querySelector('#sub_collection_selector');
    let subCollectionName = d.querySelector('#sub_collection_name');

    // update preview of image
    let imageupload = d.querySelector('#chooseFile');
    let previewHomePage = d.querySelector('#frontpagecontainer');
    let imagePreviewElement = document.querySelectorAll(".preview-selected-image");
    let Homepagepreviews = document.querySelector("#preview-selected-home-image")

    // let image_translate_selector = d.querySelectorAll('.image_translate_selector')
    let image_translateX_selector = d.querySelector('#image_translateX_selector')
    let image_translateY_selector = d.querySelector('#image_translateY_selector')
    let minusselectorY;
    let minusselectorX;
    let imageSrc;


    //   posting image

    const formtab = document.querySelector('#formtab');
    //   modal for login
    // if (modalBtn !== null) {
    //     modalBtn.onclick = function () {
    //         if (modal !== null) {
    //             modal.style.display = "block";
    //         }

    //     }
    // }
    if (navloginBtn !== null) {
        navloginBtn.onclick = function () {
            modal.style.display = "block";
        }

    }



    // if (modal !== null) {
    //     span.onclick = function () {
    //         modal.style.display = "none";
    //     }
    //     window.onclick = function (event) {
    //         if ((event.target == modal)) {
    //             modal.style.display = "none";
    //         }
    //     }
    // }


    //   open bid modal



    const markLoginError = () => {
        form.classList.add('error');
        console.log('hello')
        setTimeout(() => {
            form.classList.remove('error');
        }, 1000);
    };

    // fetch login

    if (loginBtn !== null) {
        loginBtn.addEventListener('click', (e) => {
            if (login.value.length === 0 || password.value.length === 0) {
                markLoginError();
            } else {
                fetch('/connect', {
                    headers: ajaxHeaders,
                    method: 'post',
                    redirect: 'follow',
                    body: JSON.stringify({
                        "type": "cnx",
                        "action": "connect",
                        "email": window.btoa(AesJson.encrypt(login.value, CSRF)),
                        "password": window.btoa(AesJson.encrypt(password.value, CSRF))
                    })
                }).then((response) => {
                    return response.json();
                }).then((cnx) => {
                    if (cnx.status === 401 && cnx.action === 'cnx' && cnx.connected === false) {
                        markLoginError();
                    } else if (cnx.status === 200 && cnx.action === 'cnx' && cnx.connected === true) {
                        // modal.style.display = "none";
                        window.location.href = '/admin';
                    }
                });

            }
        });
    }

    if (registerBtn !== null) {
        registerBtn.addEventListener('click', (e) => {
            if (login.value.length === 0 || password.value.length === 0 || !(passwordConfirm.value === password.value)) {
                markLoginError();
            } else {
                argon2.hash({
                    pass: password.value,
                    salt: CryptoJS.SHA3(login.value).toString(CryptoJS.enc.Hex),
                    time: 4,
                    mem: 8192,
                    hashLen: 64,
                    parallelism: 8,
                    type: argon2.ArgonType.Argon2id
                }).then(hash => {
                    fetch('?action=register', {
                        headers: ajaxHeaders,
                        method: 'post',
                        body: JSON.stringify({
                            "type": "cnx",
                            "action": "register",
                            "email": window.btoa(login.value),
                            "password": window.btoa(hash.encoded),
                            "nom": nom.value,
                            "prenom": prenom.value
                        })
                    }).then((response) => {

                        return response.json();
                    }).then((cnx) => {
                        if (cnx.status === 401 && cnx.action === 'cnx' && cnx.connected === false) {
                            markLoginError();
                        } else if (cnx.status === 200 && cnx.action === 'cnx' && cnx.connected === true) {
                            d.location.href = '/';
                        }
                    });
                });
            }
        });
    }





    // remove submit form with enter
    window.addEventListener('keydown', function (e) {
        if (e.keyIdentifier == 'U+000A' || e.keyIdentifier == 'Enter' || e.keyCode == 13) {
            if (e.target.nodeName == 'INPUT' && e.target.type == 'text') {
                e.preventDefault(); return false;
            }
        }
    }, true);



    // check if there is an homepage image to change header bg
    if (homePageImage == null && homePageImageContainer !== null && headerSelectorAdmin == null) {
        headersSelector.forEach(headerSelector => {
            let headerChild = headerSelector.children[0];
            headerChild.classList.replace('headerwhite', 'headerbrown');

        });
        d.querySelector('#instagramlogo').src = '/assets/imgs/instagram-brown.png';
    }


    // toggle dropdown
    document.addEventListener("click", (e) => {
        let clickedElem = e.target;
        if (dropdownToggle !== null) {
            do {
                if (clickedElem == dropdownToggle) {
                    dropdown.classList.toggle("show");
                    return;
                }
                clickedElem = clickedElem.parentNode;
            } while (clickedElem);
            if (dropdown.classList.contains('show'))
                dropdown.classList.remove('show')

        }

    });

    // collection selector apply id to input for form
    if (collectionSelector !== null) {
        collectionSelector.addEventListener("change", (event) => {
            if (collectionSelector.value == "Pas dans une collection") {
                collectionId.value = null;
            }
            else {
                collectionId.value = collectionSelector.value;
            }
        })
    }

    // sub collection selector apply id to input for form
    if (subCollectionSelector !== null) {
        subCollectionSelector.addEventListener("change", (event) => {
            if (subCollectionSelector.value == "Pas dans une sous-collection") {
                subCollectionName.value = "";
            }
            else {
                subCollectionName.value = subCollectionSelector.value;
            }
        })
    }

    // image preview
    // check if imageupload is present in the page
    if (imageupload !== null) {
        imageupload.addEventListener("change", (event) => {
            //Get the selected files.
            const imageFiles = event.target.files;
            //  Count the number of files selected.
            const imageFilesLength = imageFiles.length;
            //  If at least one image is selected, then proceed to display the preview.
            if (imageFilesLength > 0) {
                // Get the image path.
                imageSrc = URL.createObjectURL(imageFiles[0]);
                // Assign the path to the image preview element.
                if (homePageImageContainer !== null) {
                    // Preview of image
                    Homepagepreviews.src = imageSrc;
                    Homepagepreviews.style.display = "block";
                    Homepagepreviews.classList.add('frontpageimage')
                    // color change of the header from brown to white
                    headersSelector.forEach(headerSelector => {
                        let headerChild = headerSelector.children[0];
                        headerChild.classList.replace('headerbrown', 'headerwhite');

                    });
                    // removal of navbar background
                    headerSelectorAdmin.classList.remove('navbar-background-color')
                    postHImageWhite.forEach((item) => {
                        item.style.color = "white"
                    })

                } else {
                    imagePreviewElement.forEach((item) => {
                        item.src = imageSrc;

                    })
                }
            }
        });
    }

    if (image_translateX_selector !== null) {

        image_translateX_selector.addEventListener("change", () => {
            if (imagePreviewElement !== null) {
                /**imagePreviewElement soit les deux élément où l'apercu est afficher
                 * selon les deux tailles qui existe dans les Tabs
                 *  */

                imagePreviewElement.forEach((item) => {
                    item.style.transform = `translate(${image_translateX_selector.value}%,
                         ${image_translateY_selector.value}%)`;
                })
            }

        })
    }

    if (image_translateY_selector !== null) {


        image_translateY_selector.addEventListener("change", () => {
            if (imagePreviewElement !== null) {
                imagePreviewElement.forEach((item) => {
                    item.style.transform = `translate(${image_translateX_selector.value}%,
                         ${image_translateY_selector.value}%)`;
                })
            }

        })
    }


    // loading screen
    stop = false
    let ongoingAjax = false


    /*
    * Fetching data for infinite scroll trigger & fetch
    **/

    // fetch extra data for infinite scroll
    function loadMoreData(page) {
        if (window.location.pathname.includes('admin')) return;
        ongoingAjax = true
        fetch(window.location.pathname + '/' + page, {
            method: "GET",
            headers: ajaxHeadersGet,
        }).then(response => response.json())
            .then((data) => {
                InfiniteScroll.insertAdjacentHTML("beforeend", data.html)
                if (data.html == "" || data.html == "\r\n") stop = true
                ongoingAjax = false

            })
    }
    // function loadMoreData(page) {
    //     ongoingAjax = true
    //     fetch(window.location.pathname + '/' + page, {
    //         method: "GET",
    //        headers: ajaxHeadersGet,
    //     }).then(response => response.json())
    //     .then((data)=> {
    //         InfiniteScroll.insertAdjacentHTML("beforeend",data.html)
    //         if(data.html =="" || data.html =="\r\n") stop = true
    //         ongoingAjax = false

    //     })
    // }
    // infinite scroll 
    var page = 1;

    $(document).scroll(function (e) {
        if ($(document).scrollTop() >= $(document).height() - $(window).height()) {
            if (ongoingAjax == true || stop == true) { return };
            page++;
            loadMoreData(page);

        }

    });

    if (formtab !== null) {
        formtab.addEventListener('submit', handleSubmit)
    }

    function addDataToForm() {
        const data = new FormData

        if (nom !== null && nom.value !== "") {
            data.append('name', nom.value);
        }

        if (prenom !== null && prenom.value !== "") {
            data.append('surname', prenom.value);
        }

        if (collectionSelector !== null && collectionSelector.value !== "") {
            data.append('collections_id', collectionSelector.value);
        }

        if (subCollectionName !== null && subCollectionName.value !== "") {
            data.append('sub_collection_name', subCollectionName.value);
        }

        if (description !== null && description.value !== "") {
            data.append('description', description.value);
        }

        if (image_translateX_selector !== null) {
            data.append('translate_x', image_translateX_selector.value)
        }

        if (image_translateY_selector !== null) {
            data.append('translate_y', image_translateY_selector.value)
        }

        if (itemID !== null && itemID.value !== "") {
            data.append('id', itemID.value)
        }

        if (instagramName !== null) {
            if (instagramName.value !== "") {
                data.append('name', instagramName.value)
            }
        }

        if (instagramAddress !== null) {
            data.append('link', instagramAddress.value)
        }

        if (tabname !== null) {
            data.append('tab', tabname.value)
        }

        if (imageupload !== null) {
            if (imageupload.files[0] !== undefined) {
                if (!(typeof imageupload.files[0].length === undefined)) {
                    data.append('image', imageupload.files[0]);
                }
            }
        }

        if (CSRFPost !== null) {
            data.append('MYSHOP_CSRF_TOKEN_SESS_IDX', CSRFPost.value)
        }
        if (deleteImagePath !== null) {
            data.append('delete_image_path', deleteImagePath.value)
        }
        return data
    }


    function handleSubmit(e) {
        // event.setRequestHeader(ajaxHeaders);

        e.preventDefault();


        const data = addDataToForm()
        // let formDataObject = Object.fromEntries(data.entries());
        // // Format the plain form data as JSON
        // let formDataJsonString = JSON.stringify(formDataObject);
        var ajax_request = new XMLHttpRequest();

        ajax_request.open('POST', '/admin/post', 'admin/post');
        // Object.keys(ajaxHeadersGet).forEach(key => {
        //     // console.log()
        //     ajax_request.setRequestHeader(key, ajaxHeadersGet[key]);

        // })
        ajax_request.send(data);

        ajax_request.onreadystatechange = function () {
            if (ajax_request.readyState == 4 && ajax_request.status == 200) {
                var response = JSON.parse(ajax_request.responseText);
                if (response.message = 'success') {
                    document.getElementById('message').innerHTML = '<div class="alert alert-success"><strong>L\'image a été enregistré avec succès</strong></div>';


                } else {
                    document.getElementById('message').innerHTML = '<div class="alert alert-danger">' + response.message + '</div>';
                }
                setTimeout(function () {

                    document.getElementById('message').innerHTML = '';

                }, 5000);
            }
        }



    }

    if (deleteBtn !== null) {
        deleteBtn.addEventListener('click', (e) => {
            if (itemID !== null) {
                if (itemID.value == "") {
                    document.getElementById('message').innerHTML = '<div class="alert alert-danger">Vous n\'avez pas sélectionné de collection à supprimer</div>';
                    setTimeout(function () {
                        document.getElementById('message').innerHTML = '';
                    }, 5000);
                    return;
                }
            }


            fetch('/admin/post', {
                headers: ajaxHeaders,
                method: 'post',
                body: JSON.stringify({
                    "action": "delete",
                    "tab": tabname.value,
                    "id": itemID.value,
                })
            }).then((response) => {

                return response.json();
            }).then((response) => {
                if (response.message == 'success') {
                    document.getElementById('message').innerHTML = '<div class="alert alert-success"><strong>L\'élément a bien été supprimé</strong></div>';
                    setTimeout(function () {
                        let url = window.location.pathname
                        url = url.split('/')
                        let lastElement = url.slice(-1)
                        url = url.split('/')
                        url.pop()
                        url = url.join('/')
                        if (parseInt(lastElement) > 0) {
                            window.location.href = url
                        } else {
                            location.reload()
                        }

                    }, 5000);
                } else {
                    document.getElementById('message').innerHTML = '<div class="alert alert-danger">L\élément n\'a  pas pu être supprimé ou n\'existe plus</div>';
                    setTimeout(function () {
                        document.getElementById('message').innerHTML = '';
                    }, 5000);
                }
            });
        });
    }

    //  fetch de l'image d'accueil pour la modifier
    if (homeImageIDSelector !== null) {
        let homeImageEditPreview = false


        homeImageIDSelector.addEventListener('change', function (e) {
            fetch('/admin/home-image/' + homeImageIDSelector.value, {
                method: "GET",
                headers: ajaxHeadersGet,
            }).then((response) => {
                return response.json();
            }).then((data) => {
                if (data.html !== "") {
                    afterheader.innerHTML = data.html
                    homeImageEditPreview = true;
                }


            }).then((data) => {
                if (deleteImagePath !== null) {


                }
            });
        })

        if (homeImageEditPreview === true) {
            Homepagepreviews.src = deleteImagePath.value
            Homepagepreviews.style.display = "block";
            Homepagepreviews.classList.add('frontpageimage')
            homeImageEditPreview = false
        }
    }
});

