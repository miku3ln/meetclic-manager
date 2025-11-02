var config = {
    apiKey: "AIzaSyAnVYD58myCBjiYtQgZ4h9aBF1yetjuf9w",
    authDomain: "wulpym-35dc6.firebaseapp.com",
    databaseURL: "https://wulpym-35dc6.firebaseio.com",
    projectId: "wulpym-35dc6",
    storageBucket: "wulpym-35dc6.appspot.com",
    messagingSenderId: "1029565298273"
};
firebase.initializeApp(config);

var database = firebase.database();
var refCurrent = "business";
var db = firebase.database();
var firebaseOrdersCollection = database.ref().child(refCurrent);
var lastRef;

function searchFirebase(searchTerm) {
    var type = "name";
    var equal = false;
    var ref = searchType({search: searchTerm, searchKey: "title"});
    ref.once('value', showResults, errors);
}


function showResults(snap) {
    if (snap) {
        console.log(snap.val());
    }
}

function errors(snap) {
    console.log(snap);
}

function initFirebaseEvents() {
    console.log("init fb");
    database.ref(refCurrent).on('child_added', function (data) {
        console.log("child_ad");
    });
    database.ref(refCurrent).on('child_changed', function (data) {
        //update_data_table(data.val().username, data.val().profile_picture, data.val().email, data.key)
        console.log("child_changed");

    });
    database.ref(refCurrent).on('child_removed', function (data) {
        //remove_data_table(data.key)
    });
    database.ref(refCurrent).on("value", function (snap) {
        console.log("initial data loaded!", snap.numChildren());
    });

}

function firebaseCustomMethods() {
    var fi = {
            firebase: {
                business: db.ref(refCurrent)
            }
        }
    ;
    var info = {
        getRefSearch: function (params) {
            var type = params.type;
            var searchTerm = params.search;
            var initData = params.init;

            var searchKey = params.searchKey;
            var equals = params.equals;
            var ref;
            var orderByChild = searchKey;
            if (initData) {

                ref = database.ref(refCurrent).orderByChild(orderByChild)
                    .startAt(searchTerm)
                    .endAt(searchTerm + '~');

                if (equals) {
                    ref = database.ref(refCurrent).orderByChild(orderByChild).equalTo(searchTerm);
                }

            } else {
                ref = database.orderByChild(searchKey);
            }
            return ref;
        },
        searchData: function () {
            var ref = this.getRefSearch({init: true, searchKey: "title"});
            ref.once('value', this.showResults, errors);
        },
        initData: function () {
            var ref = this.getRefSearch({init: true, searchKey: "title"});
            ref.once('value', this.showResults);
        },
        showResults: function (snap) {
            var _this = this;
            if (snap) {
                this.initDataRows.count = snap.numChildren();
                var valuesCurrent = snap.val();
                $.each(valuesCurrent, function (index, value) {
                    console.log(index, value);
                    var title = value.title;
                    var lat = value.street_lat;
                    var lng = value.street_lng;
                    var business_subcategory_id = value.business_subcategory_id;
                    var subcategori = getSubCategory(business_subcategory_id);
                    var width = 50, height = 60;
                    var iconCurrent = {
                        url: subcategori.marker,
                        scaledSize: new google.maps.Size(width, height), // scaled size
                        origin: new google.maps.Point(0, 0), // origin
                        anchor: new google.maps.Point(0, 0) // anchor
                    };
                    var content = "<div>" + title + "</div>";
                    var marker_object = new google.maps.Marker({
                        draggable: false,
                        title: title,
                        animation: google.maps.Animation.DROP,
                        position: new google.maps.LatLng(lat, lng),
                        icon: iconCurrent,
                    });
                    var params_data = {map: map, marker: marker_object, content: content};


                    _this.wulpyMapUtil().addMarker(params_data);
                });
                var markerCluster = new MarkerClusterer(map, markers,
                    {imagePath: pathDevelopers + "assets/images/cluster/"});
            } else {
                this.initDataRows.count = 0;
            }
        },
        removeBusiness(row) {
            console.log(row);
        },
        getDataRows: function () {
            var promiseResult = new Promise((resolve, reject) => {
                database.ref(refCurrent).on("value", function (snap) {
                    console.log("initial data loaded!", snap.numChildren());
                    resolve(snap);
                });

            });
            return promiseResult;
        },

        initDabase: function () {

        }, initManagement: function () {
            this.initDabase();
            setConfigMap();
            console.log("OBJETC APP", this);


            this.wulpyMapUtil().initMap("#map", this.business);
            this.initData();
        },
        wulpyMapUtilMethods: function () {
            return WulpyMapUtil();
        }
    }
}