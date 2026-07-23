const fs = require('fs');
const text = fs.readFileSync('resources/views/home.blade.php', 'utf8');
const re = /style="([\s\S]*?)"/g;
let m;
const styles = new Map();
while ((m = re.exec(text)) !== null) {
    const style = m[1];
    if (!styles.has(style)) styles.set(style, []);
    styles.get(style).push(m.index);
}
console.log('Unique multiline styles:', styles.size);
