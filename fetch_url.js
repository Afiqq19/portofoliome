const https = require('https');
const fs = require('fs');
https.get('https://portofoliomsyafiq19.vercel.app', (res) => {
    let data = '';
    res.on('data', (chunk) => data += chunk);
    res.on('end', () => {
        fs.writeFileSync('d:\\antigravity\\portofoliome\\fetch_result.txt', `STATUS: ${res.statusCode}\n\n${data}`);
        console.log('done');
    });
});
