const fs = require('fs');
const text = fs.readFileSync('resources/views/home.blade.php', 'utf8');
const re = /style="([\s\S]*?)"/g;
const styles = new Map();
let m;
while ((m = re.exec(text)) !== null) {
    const style = m[1];
    if (!styles.has(style)) styles.set(style, []);
    styles.get(style).push(m.index);
}
const entries = Array.from(styles.entries());
console.log('Unique styles:', entries.length);
// write to file for inspection
fs.writeFileSync('unique_styles.json', JSON.stringify(entries.map((e,i)=>e[0]), null, 2), 'utf8');
console.log('Wrote unique_styles.json');
