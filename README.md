# LearnHub — Laravel ব্যবহারিক পরীক্ষা

স্বাগতম! এই পরীক্ষায় আপনি একটা আংশিক বানানো Laravel অ্যাপে তিনটা কাজ করবেন। মোট নম্বর **৪০**।

## কাজের তালিকা

- [ ] **কাজ ১** — কোর্স কার্ড সুন্দর করা (১০ নম্বর) → [বিস্তারিত](#৪-কাজ-১--কোর্স-কার্ড-সুন্দর-করা-১০-নম্বর)
- [ ] **কাজ ২** — ক্যাটাগরি ফিল্টার ঠিক করা (১০ নম্বর) → [বিস্তারিত](#৫-কাজ-২--ক্যাটাগরি-ফিল্টার-ঠিক-করা-১০-নম্বর)
- [ ] **কাজ ৩** — কোর্স ডিটেইল পেজ বানানো (২০ নম্বর) → [বিস্তারিত](#৬-কাজ-৩--কোর্স-ডিটেইল-পেজ-বানানো-২০-নম্বর)
- [ ] **বোনাস** — দাম `0` হলে "Free" ব্যাজ (মূল ৪০-এর বাইরে)

---

## ১. অ্যাপ পরিচিতি

LearnHub একটা ছোট e-learning ওয়েবসাইট। এখন এতে শুধু কোর্সের তালিকা আছে:

- উপরে ক্যাটাগরির chip (All, Programming, Design ...)
- নিচে কোর্সের কার্ড

ডাটা থাকে ডাটাবেসে (SQLite)। টেবিলগুলো migration দিয়ে বানানো, আর ডাটা seeder দিয়ে `database/data/learnhub.json` ফাইল থেকে ঢোকানো হয়।

প্রজেক্টের কাঠামো (যেগুলো নিয়ে কাজ করবেন):

```
app/
├── Http/Controllers/CourseController.php
└── Models/                         # Category, Course
database/
├── data/learnhub.json              # সব ডাটা
├── migrations/                     # categories, courses, lessons টেবিল
└── seeders/LearnHubSeeder.php
resources/views/
├── layouts/app.blade.php           # সব পেজের কাঠামো (header)
└── courses/
    ├── index.blade.php             # কোর্স লিস্ট
    └── partials/course-card.blade.php
public/css/app.css                  # সব CSS
routes/web.php
```

এই প্রজেক্টে কোনো frontend framework বা library (Tailwind, Bootstrap, Vue, React, jQuery, Vite ইত্যাদি) নেই। শুধু **Blade, সাধারণ HTML, CSS আর দরকার হলে সাধারণ JavaScript**। আপনিও এভাবেই কাজ করবেন, নতুন কোনো প্যাকেজ (composer বা npm) যোগ করবেন না।

---

## ২. চালানোর নিয়ম

PHP 8.3 বা তার বেশি আর Composer লাগবে।

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
php artisan serve
```

ব্রাউজারে খুলুন: http://localhost:8000

কোর্সের তালিকা দেখা যাওয়ার কথা। না দেখালে পরীক্ষককে জানান।

> ডাটা নষ্ট হয়ে গেলে নতুন করে শুরু করতে: `php artisan migrate:fresh --seed`

---

## ৩. ডাটাবেস

| টেবিল | কলাম |
|---|---|
| `categories` | `id`, `name` |
| `courses` | `id`, `category_id`, `title`, `instructor`, `short_summary`, `description`, `price`, `rating`, `duration_minutes`, `thumbnail` |
| `lessons` | `id`, `course_id`, `title`, `duration_minutes`, `sort_order` |

- একটা category-র অনেক course, একটা course-এর অনেক lesson।
- `Category` আর `Course` model আছে। `Lesson` model **নেই**।
- `Course` model-এ `price` cast করা আছে `decimal:2`, তাই `$course->price` দেয় `"1200.00"` বা `"499.50"` (string)।

কাজ শুরু করার আগে `database/data/learnhub.json` বা migration ফাইল দেখে নিন কোন কলামের নাম কী।

---

## ৪. কাজ ১ — কোর্স কার্ড সুন্দর করা (১০ নম্বর)

ফাইল: `resources/views/courses/partials/course-card.blade.php` আর `public/css/app.css`

এখন কার্ডটা একদম সাধারণ: লেখাগুলো কিনারায় লেগে আছে, লম্বা summary পুরোটা দেখায়, সব লেখা একই রকম। নিচের মতো করে সাজান:

| অংশ | যা করতে হবে |
|---|---|
| **Title** | `font-weight: bold`, `font-size: 18px`, রং `#3f51b5` |
| **Summary** | `font-size: 13px`, রং `#757575`, সর্বোচ্চ **২ লাইন**, বেশি হলে শেষে `...` |
| **Price** | `font-weight: bold`, `font-size: 20px`, রং `#388e3c`, সামনে `৳`। দাম পূর্ণসংখ্যা হলে দশমিক ছাড়া (`৳ 1200`), না হলে দুই ঘর দশমিক (`৳ 499.50`) |
| **কার্ড** | ভিতরে চারদিকে `16px` padding, কোণ গোল (`border-radius: 12px`), কার্ডগুলোর মাঝে ফাঁকা জায়গা |
| **নিচের সারি** | বাঁ দিকে দাম, ডান দিকে **Details** বাটন — রঙিন ব্যাকগ্রাউন্ড (`#3f51b5`) আর সাদা লেখা |

কার্ডে ছবি দেখানোর দরকার নেই।

---

## ৫. কাজ ২ — ক্যাটাগরি ফিল্টার ঠিক করা (১০ নম্বর)

উপরের ক্যাটাগরি chip-গুলো দেখা যায়, চাপলে URL-ও বদলায়, কিন্তু তালিকায় কিছু বদলায় না।

ফিল্টারটা ঠিক করুন, যাতে:

- কোনো chip চাপলে সেটা সিলেক্টেড (active) দেখায়
- শুধু ওই ক্যাটাগরির কোর্সগুলো আসে
- **All** চাপলে আবার সব কোর্স ফেরত আসে

---

## ৬. কাজ ৩ — কোর্স ডিটেইল পেজ বানানো (২০ নম্বর)

কার্ডের **Details** বাটন চাপলে একটা নতুন পেজ খুলবে, যেখানে কোর্সের বিস্তারিত দেখাবে।

> **গুরুত্বপূর্ণ:** Details লিংকের URL-এ শুধু কোর্সের `id` যাবে (যেমন `/courses/3`), আর ডিটেইল পেজ নিজে সেই `id` দিয়ে ডাটাবেস থেকে কোর্স আনবে।
> ভুল `id` দিলে (যেমন `/courses/999`) **404** পেজ আসতে হবে, error নয়।

যা যা লাগবে:

1. `routes/web.php`-এ নতুন route, নাম `courses.show`
2. `CourseController`-এ নতুন `show` মেথড
3. `Lesson` model (`app/Models/Lesson.php`), আর `Course` model-এ lesson-গুলোর relationship
4. নতুন view: `resources/views/courses/show.blade.php` — `layouts.app` extend করবে

পেজে যা দেখাবে:

- **উপরের header-এ** back লিংক (চাপলে লিস্টে ফেরত যাবে) আর কোর্সের নাম
- **উপরে ছবি** (`thumbnail`) — ছবি লোড না হলে ভাঙা ছবির আইকন নয়, একটা ধূসর placeholder দেখাবে
- কোর্সের **title**, **শিক্ষকের নাম**, **দাম** (কাজ ১-এর মতো ফরম্যাটে)
- **সময়কাল** ঘণ্টা-মিনিটে, যেমন `95` মিনিট → `1h 35m`
- পুরো **description**
- তারপর **"Lessons"** শিরোনাম, তার নিচে শুধু এই কোর্সের লেসনগুলো, `sort_order` অনুযায়ী — প্রতিটায় নম্বর, নাম আর কত মিনিট
- কোনো লেসন না থাকলে "No lessons yet." লেখা

---

## ৭. নিয়ম

- সময়: **১ ঘণ্টা ২০ মিনিট**
- Google, StackOverflow আর অফিসিয়াল ডকুমেন্টেশন (laravel.com/docs, developer.mozilla.org) ব্যবহার করতে পারবেন।
- প্রতিটা কাজ শেষে আলাদা git commit করবেন:
  - `feat: style course card`
  - `fix: category filter`
  - `feat: course detail page`
- সব কাজ শেষ না হলেও যতটুকু হয়েছে জমা দেবেন। আংশিক কাজেও নম্বর আছে।
- জমা দেওয়ার পর ছোট একটা ভাইভা হবে, যেখানে আপনার প্রতিটা পরিবর্তন নিজে ব্যাখ্যা করতে হবে।

---

## ৮. বোনাস (মূল ৪০ নম্বরের বাইরে)

যে কোর্সের দাম `0`, তার কার্ডে দামের পাশে একটা ছোট **"Free"** ব্যাজ দেখান।

শুভকামনা!
