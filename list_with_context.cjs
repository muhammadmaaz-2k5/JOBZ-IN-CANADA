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
        styles[style].push({ line: i+1, tag: tag.slice(0,80), context: lines[i].slice(0, 200) });
    }
}
const entries = Object.entries(styles);
console.log('Unique styles:', entries.length);
entries.forEach(([style, arr], idx) => {
    console.log(`\n# ${idx+1} --- occurrences: ${arr.length}`);
    arr.forEach(a => console.log(`  line ${a.line}: ${a.tag}`));
    console.log(`  style: ${style}`);
});
