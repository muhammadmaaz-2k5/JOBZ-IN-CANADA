const fs = require('fs');
const lines = fs.readFileSync('resources/views/home.blade.php', 'utf8').split('\n');
const occurrences = [];
const re = /(<[^>]+?)\s+style="([^"]+?)"/g;
for (let i = 0; i < lines.length; i++) {
    let m;
    while ((m = re.exec(lines[i])) !== null) {
        occurrences.push({ line: i+1, col: m.index, tag: m[1], style: m[2] });
    }
}
console.log('Total inline styles:', occurrences.length);
occurrences.forEach(o => {
    console.log(`${o.line}:${o.col} | ${o.tag.slice(0,80)} | ${o.style.slice(0,120)}`);
});
