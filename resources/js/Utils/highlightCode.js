import lowlight from "../data/highlightLanguages";

function escapeHtml(html) {
    return html.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
}

function toHtml(node) {
    if (node.type === 'text') {
        return node.value
    } else if (node.type === 'element') {
        const className = node.properties.className
            ? node.properties.className.join(' ')
            : '';
        const children = node.children.map(toHtml).join('');
        return `<${node.tagName} class='${className}'>${children}</${node.tagName}>`;
    } else if (node.type === 'root') {
        return node.children.map(toHtml).join('');
    } else {
        return '';
    }
}

export function highlightCode(body, secondParam) {
    let applyHljsClass = false; // Default is false

    // If the second parameter is a boolean, it's the `applyHljsClass` flag
    if (typeof secondParam === "boolean") {
        applyHljsClass = secondParam;
    }

    const codeBlocks = body.match(/```(.*?)\n([\s\S]*?)```/g);
    if (codeBlocks) {
        codeBlocks.forEach(block => {
            const [, language, code] = block.match(/```(.*?)\n([\s\S]*?)```/);

            // If language is specified use it, otherwise use highlightAuto for automatic detection
            let result;
            if (language.trim()) {
                result = lowlight.highlight(language.trim(), code.trim());
            } else {
                result = lowlight.highlightAuto(code.trim()); // Automatically detect language
            }

            const highlighted = toHtml(result);
            const hljsClass = applyHljsClass ? ' class="hljs"' : ""; // Apply hljs class if needed
            body = body.replace(
                block,
                `<pre><code${hljsClass}>${highlighted}</code></pre>`
            );
        });
    }

    const htmlCodeBlocks = body.match(/<pre><code>([\s\S]*?)<\/code><\/pre>/g);
    if (htmlCodeBlocks) {
        htmlCodeBlocks.forEach((block) => {
            let code = block.replace(/<pre><code>|<\/code><\/pre>/g, "");
            const result = lowlight.highlightAuto(code.trim()); // Automatic detection
            const highlighted = toHtml(result);
            const hljsClass = applyHljsClass ? ' class="hljs"' : ""; // Apply hljs class if needed
            body = body.replace(
                block,
                `<pre><code${hljsClass}>${highlighted}</code></pre>`
            );
        });
    }

    // If secondParam is a function, apply it (e.g., `this.decodeHtml`)
    if (typeof secondParam === "function") {
        return secondParam(body);
    }

    return body;
}
