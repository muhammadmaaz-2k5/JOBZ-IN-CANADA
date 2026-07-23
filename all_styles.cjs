const fs = require('fs');
const text = fs.readFileSync('resources/views/home.blade.php', 'utf8');
const re = /style="([\s\S]*?)"/g;
let m;
const occurrences = [];
let idx = 0;
while ((m = re.exec(text)) !== null) {
    const start = m.index + m[0].indexOf('style="');
    const line = text.slice(0, start).split('\n').length;
    const style = m[1];
    const tagMatch = text.slice(0, start).match(/<[^>]*$/);
    const tag = tagMatch ? tagMatch[0].slice(-60) : '';
    occurrences.push({ line, style, tag: tag.slice(0, 80) });
    idx++;
}
console.log('Total style attrs (incl multiline):', occurrences.length);
occurrences.forEach((o, i) => {
    console.log(`#${i+1} line ${o.line}: ${o.tag} | ${o.style.slice(0, 120)}`);
});
