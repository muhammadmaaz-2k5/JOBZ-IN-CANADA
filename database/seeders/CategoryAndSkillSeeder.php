<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoryAndSkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Hierarchical Categories
        $categories = [
            'Engineering' => [
                'Software Development',
                'Mobile Development',
                'DevOps',
                'QA'
            ],
            'Design' => [
                'UI Design',
                'UX Design',
                'Graphic Design'
            ],
            'Marketing' => [
                'Digital Marketing',
                'SEO',
                'Content Marketing'
            ]
        ];

        foreach ($categories as $parentName => $children) {
            $parent = Category::create([
                'name' => $parentName,
                'slug' => Str::slug($parentName),
                'parent_id' => null,
                'icon' => 'briefcase',
            ]);

            foreach ($children as $childName) {
                Category::create([
                    'name' => $childName,
                    'slug' => Str::slug($childName),
                    'parent_id' => $parent->id,
                    'icon' => 'chevron-right',
                ]);
            }
        }

        // 2. Seed Master Skills directory
        $skills = [
            'Laravel', 'PHP', 'Node.js', 'React', 'Next.js', 
            'Flutter', 'Docker', 'AWS', 'Kubernetes', 'MySQL',
            'HTML', 'CSS', 'JavaScript', 'Python', 'Git',
            'TypeScript', 'Vue.js', 'Tailwind CSS', 'PostgreSQL', 'Redis'
        ];

        foreach ($skills as $skillName) {
            Skill::create([
                'name' => $skillName,
                'slug' => Str::slug($skillName),
            ]);
        }
    }
}
