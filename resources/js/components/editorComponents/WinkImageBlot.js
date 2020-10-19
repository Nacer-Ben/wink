import Quill from 'quill';

let BlockEmbed = Quill.import('blots/block/embed');

class WinkImageBlot extends BlockEmbed {
    static create(value) {
        let node = super.create();
        let img = document.createElement('img');

        node.setAttribute('contenteditable', false);
        node.dataset.layout = value.layout;

        img.setAttribute('alt', value.caption);
        img.setAttribute('src', value.url);
        img.setAttribute('class', 'mx-auto');
        node.appendChild(img);

        if (value.caption) {
            let caption = document.createElement('p');
            caption.setAttribute('class', 'text-center')
            caption.innerHTML = value.caption;
            node.appendChild(caption);
        }

        return node;
    }

    static value(node) {
        let img = node.querySelector('img');

        return {
            layout: node.dataset.layout,
            caption: img.getAttribute('alt'),
            url: img.getAttribute('src')
        };
    }
}

WinkImageBlot.tagName = 'div';
WinkImageBlot.blotName = 'captioned-image';
WinkImageBlot.className = 'embedded_image';

export default WinkImageBlot;
