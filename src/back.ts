/**
*  @author    sHKamil - Kamil Hałasa
*  @copyright sHKamil - Kamil Hałasa
*  @license   .l
*/

type comment = {
    id_clientcomments: number,
    client_name: string,
    message: string,
    active: number
}

async function fetchAPI(url: string, method: string, data?: any) {   
    try {
        const response = await fetch(
            url,
            {
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
        let comments: comment[] = [];
        result.forEach((el: comment) => {
            comments.push(el);
        })
        
        return result;

    } catch (error) {
        // Handle errors
        console.error('Error:', error);
    }
}

const setActiveSwitch = (id: number) => {
    let toActivate = <HTMLInputElement> document.getElementById(id.toString());
    toActivate.checked = true;
}

let response = fetchAPI('/module/clientcomments/GatherComments?method=getActiveJSON', 'GET');

response.then((comments) => {
    comments.forEach((el: comment) => {
        setActiveSwitch(el.id_clientcomments);
    })
});
