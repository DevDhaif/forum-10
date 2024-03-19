import { createLowlight } from 'lowlight';

const lowlight = createLowlight();

const languages = {
    html: () => import('highlight.js/lib/languages/xml'),
    css: () => import('highlight.js/lib/languages/css'),
    javascript: () => import('highlight.js/lib/languages/javascript'),
    python: () => import('highlight.js/lib/languages/python'),
    java: () => import('highlight.js/lib/languages/java'),
    cpp: () => import('highlight.js/lib/languages/cpp'),
    csharp: () => import('highlight.js/lib/languages/csharp'),
    php: () => import('highlight.js/lib/languages/php'),
    sql: () => import('highlight.js/lib/languages/sql'),
    swift: () => import('highlight.js/lib/languages/swift'),
    typescript: () => import('highlight.js/lib/languages/typescript'),
    kotlin: () => import('highlight.js/lib/languages/kotlin'),
    ruby: () => import('highlight.js/lib/languages/ruby'),
    go: () => import('highlight.js/lib/languages/go'),
    c: () => import('highlight.js/lib/languages/c'),
    r: () => import('highlight.js/lib/languages/r'),
    bash: () => import('highlight.js/lib/languages/bash'),
    dart: () => import('highlight.js/lib/languages/dart'),
};

Object.entries(languages).forEach(async ([name, importFn]) => {
    const languageModule = await importFn();
    lowlight.register(name, languageModule.default);
});

export default lowlight;
