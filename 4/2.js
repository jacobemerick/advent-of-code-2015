var crypto = require('crypto');

var input = 'iwrupvqb',
    nonce = 1;

while (true) {
    var hash = crypto.createHash('md5');
    hash.update(input + nonce, 'ascii');
    var digest = hash.digest('hex');

    if (digest.substr(0, 6) === '000000') {
        console.log(nonce);
        console.log(digest);
        break;
    }

    nonce += 1;
}
