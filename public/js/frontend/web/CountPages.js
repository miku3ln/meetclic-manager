function managerCountsPage(token, pageCurrent) {
    var pathCurrentManager = 'meetclic';
    var childPath = pathCurrentManager + '/sessionsManager/log';
    var params = {
        token: token,
        page: pageCurrent,
        pathCurrentManager: childPath
    };
    searchUserDataLog(params).then(snapshot => {
        const dataSnap = snapshot.val();
        if (dataSnap) {
            managerVisitsCustomer({
                token: token,
                page: pageCurrent,
                count: dataSnap.count + 1,
                pathCurrentManager: pathCurrentManager
            }).then(result => {
                console.log('result create managerVisitsCustomer', result)
            });

        } else {
            managerVisitsCustomer({
                token: token,
                page: pageCurrent,
                count: 1,
                pathCurrentManager: pathCurrentManager
            }).then(result => {
                console.log('result update managerVisitsCustomer', result)
            });

            searchFireBase({
                'needle': 'countAllPages',
                'haystack': pathCurrentManager + '/sessionsManager'
            }).then(result => {
                var countCurrent = result.val() + 1;
                updateData({
                    idManager: 'countAllPages',
                    pathReference: pathCurrentManager + '/sessionsManager',
                    postData: countCurrent
                }).then(result => {
                    console.log('result update updateData pages', result)
                });
            });

            //MANAGER PAGES COUNTS
            searchFireBase({
                'needle': 'countAllPage' + pageCurrent,
                'haystack': pathCurrentManager + '/sessionsManager'
            }).then(result => {
                console.log('managerpages count', result);
                if (result.val()) {

                } else {
                    console.log('new');
                    updateData({
                        idManager: 'countAllPage' + pageCurrent,
                        pathReference: pathCurrentManager + '/sessionsManager',
                        postData: 1
                    }).then(result => {
                        console.log('result update updateData page Current', result)
                    });
                }
                /*
*/
            });

        }

    });


}

function managerVisitsCustomer(params) {
    var token = params['token'];
    var page = params['page'];
    var count = params['count'];
    var pathCurrentManager = params['pathCurrentManager'];
    var postData = {
        count: count
    };
    // Get a key for a new Post.
    var pathReference = pathCurrentManager + '/sessionsManager/log';
    return updateData({
        idManager: token,
        pathReference: pathReference,
        postData: postData
    });
}

function updateData(params) {
    var idManager = params['idManager'];
    var pathReference = params['pathReference'];
    var postData = params['postData'];
    var updates = {};
    updates['/' + pathReference + '/' + idManager] = postData;
    return firebase.database().ref().update(updates);
}

function searchUserDataLog(params) {
    var token = params['token'];
    var page = params['page'];
    var pathCurrentManager = params['pathCurrentManager'];
    return searchFireBase({
        'needle': token,
        'haystack': pathCurrentManager
    });
}

function searchFireBase(params) {
    var needle = params['needle'];
    var haystack = params['haystack'];
    var pathCurrentManager = haystack;
    return firebase.database().ref(pathCurrentManager).child(needle).once('value');
}

function getData() {
    var d = "17-09-2013 10:08",
        dArr = d.split('-'),
        ts = new Date(dArr[1] + "-" + dArr[0] + "-" + dArr[2]).getTime();

    var dbRef2 = firebase.database().ref('/meetclic/sessionsManager').orderByKey().startAt('1587704400000').endAt('1587790800000').once('value').then(snapshot => {

        const post = snapshot.val();
        console.log(post);


    })
}
