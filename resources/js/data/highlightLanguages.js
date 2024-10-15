import { createLowlight } from "lowlight";

const lowlight = createLowlight();

// const languages = {
//     html: () => import('highlight.js/lib/languages/xml'),
//     css: () => import('highlight.js/lib/languages/css'),
//     javascript: () => import('highlight.js/lib/languages/javascript'),
//     python: () => import('highlight.js/lib/languages/python'),
//     java: () => import('highlight.js/lib/languages/java'),
//     cpp: () => import('highlight.js/lib/languages/cpp'),
//     csharp: () => import('highlight.js/lib/languages/csharp'),
//     php: () => import('highlight.js/lib/languages/php'),
//     sql: () => import('highlight.js/lib/languages/sql'),
//     swift: () => import('highlight.js/lib/languages/swift'),
//     typescript: () => import('highlight.js/lib/languages/typescript'),
//     kotlin: () => import('highlight.js/lib/languages/kotlin'),
//     ruby: () => import('highlight.js/lib/languages/ruby'),
//     go: () => import('highlight.js/lib/languages/go'),
//     c: () => import('highlight.js/lib/languages/c'),
//     r: () => import('highlight.js/lib/languages/r'),
//     bash: () => import('highlight.js/lib/languages/bash'),
//     dart: () => import('highlight.js/lib/languages/dart'),
// };

// Object.entries(languages).forEach(async ([name, importFn]) => {
//     const languageModule = await importFn();
//     lowlight.register(name, languageModule.default);
// });

import html from "highlight.js/lib/languages/xml";
import css from "highlight.js/lib/languages/css";
import javascript from "highlight.js/lib/languages/javascript";
import python from "highlight.js/lib/languages/python";
import java from "highlight.js/lib/languages/java";
import cpp from "highlight.js/lib/languages/cpp";
import csharp from "highlight.js/lib/languages/csharp";
import php from "highlight.js/lib/languages/php";
import sql from "highlight.js/lib/languages/sql";
import swift from "highlight.js/lib/languages/swift";
import typescript from "highlight.js/lib/languages/typescript";
import kotlin from "highlight.js/lib/languages/kotlin";
import ruby from "highlight.js/lib/languages/ruby";
import go from "highlight.js/lib/languages/go";
import c from "highlight.js/lib/languages/c";
import r from "highlight.js/lib/languages/r";
import bash from "highlight.js/lib/languages/bash";
import dart from "highlight.js/lib/languages/dart";
import plaintext from "highlight.js/lib/languages/plaintext";

lowlight.register("html", html);
lowlight.register("css", css);
lowlight.register("javascript", javascript);
lowlight.register("python", python);
lowlight.register("java", java);
lowlight.register("cpp", cpp);
lowlight.register("csharp", csharp);
lowlight.register("php", php);
lowlight.register("sql", sql);
lowlight.register("swift", swift);
lowlight.register("typescript", typescript);
lowlight.register("kotlin", kotlin);
lowlight.register("ruby", ruby);
lowlight.register("go", go);
lowlight.register("c", c);
lowlight.register("r", r);
lowlight.register("bash", bash);
lowlight.register("dart", dart);
lowlight.register("plaintext", plaintext);
export default lowlight;
