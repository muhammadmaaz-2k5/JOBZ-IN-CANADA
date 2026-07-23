const fs = require('fs');
const lines = fs.readFileSync('resources/views/home.blade.php', 'utf8').split('\n');
const re = /(<[^>]+?)\s+style="([^"]+?)"/g;
const styles = {};
for (let i = 0; i < lines.length; i++) {
    let m;
    while ((m = re.exec(lines[i])) !== null) {
        const tag = m[1];
        const style = m[2];
        if (!styles[style]) {
            styles[style] = [];
        }
        styles[style].push({ line: i+1, tag });
    }
}
console.log('Unique styles:', Object.keys(styles).length);
Object.entries(styles).forEach(([style, arr]) => {
    console.log('---');
    console.log(arr.map(a => `${a.line}: ${a.tag.slice(0,60)}`).join('\n'));
    console.log(style);
});
