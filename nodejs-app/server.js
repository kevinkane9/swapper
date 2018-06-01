const express = require('express');
const bodyParser = require('body-parser');

var app = express();
app.use(bodyParser.urlencoded({ extended: false }));
app.use(express.json());

var documentClient = require("documentdb").DocumentClient;
var config = require("./config");
var url = require('url');

var client = new documentClient(config.endpoint, { "masterKey": config.primaryKey });

function queryCollection(collectionUrl, querySpec) {
    return new Promise((resolve, reject) => {
        client.queryDocuments(
            collectionUrl,
            querySpec,
            { enableCrossPartitionQuery: true }
        ).toArray((err, results) => {
            if (err) reject(err)
            else {
                for (var queryResult of results) {
                    let resultString = JSON.stringify(queryResult);
                    console.log(`\tQuery returned ${resultString}`);
                }
                console.log();
                resolve(results);
            }
        });
    });
};

function upsert(collectionUrl, document) {
    return new Promise((resolve, reject) => {
        client.replaceDocument(
            `${collectionUrl}/docs/` + document.id,
            document,
            function (err, updated) {
                if (err) {
                    if (404 == err.code) {
                        
                        client.createDocument(collectionUrl, document, function (err, document) {
                            if (err) {
                                reject(err);
                            } else {
                                resolve();
                            }
                        });
                        
                    } else {
                        reject(err);
                    }
                } else {
                    resolve(updated);
                }
            }
        ); 
    });
};

app.post('/query', (req, res) => {
    
    let databaseUrl = `dbs/${req.body.database}`;
    let collectionUrl = `${databaseUrl}/colls/${req.body.collection}`;
    
    let parameters = [];
    
    for (key in req.body.params) {
        parameters.push({
            "name": key,
            "value": req.body.params[key]
        });
    }
    
    let querySpec = {
        'query': req.body.query,
        'parameters': parameters
    };
    
    queryCollection(collectionUrl, querySpec).then(
        function(success){
            let response = {'status': 'success', 'result': success};
            res.send(JSON.stringify(response));
        },
        function(error){
            let response = {'status': 'error', 'error': error};
            res.send(JSON.stringify(response));
        }
    );
});

app.post('/upsert', (req, res) => {
    
    let databaseUrl = `dbs/${req.body.database}`;
    let collectionUrl = `${databaseUrl}/colls/${req.body.collection}`;
    
    upsert(collectionUrl, req.body.document).then(
        function(success){
            let response = {'status': 'success'};
            res.send(JSON.stringify(response));
        },
        function(error){
            let response = {'status': 'error', 'error': error};
            res.send(JSON.stringify(response));
        }
    );
});

app.listen(3939);