"use strict";
/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/
async function fetchAPI(url, method, data) {
    try {
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
            },
            body: data ? JSON.stringify(data) : undefined,
        });
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const result = await response.json();
        let comments = [];
        result.forEach((el) => {
            comments.push(el);
        });
        return result;
    }
    catch (error) {
        // Handle errors
        console.error('Error:', error);
    }
}
const setActiveSwitch = (id) => {
    let toActivate = document.getElementById(id.toString());
    toActivate.checked = true;
};
let response = fetchAPI('/module/clientcomments/GatherComments?method=getActiveJSON', 'GET');
response.then((comments) => {
    comments.forEach((el) => {
        setActiveSwitch(el.id_clientcomments);
    });
});
