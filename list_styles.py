import re
with open('resources/views/home.blade.php') as f:
    lines = f.readlines()
occurrences = []
for i, line in enumerate(lines):
    for m in re.finditer(r'(<[^>]+?)\s+style="([^"]+?)"', line):
        occurrences.append((i+1, m.start(), m.group(1), m.group(2)))
print(f'Total inline styles: {len(occurrences)}')
for ln, pos, tag, style in occurrences:
    print(f'{ln}:{pos} | {tag[:80]} | {style[:120]}')
