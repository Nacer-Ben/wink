import Quill from 'quill'
import DOMPurify from 'dompurify';

const List = Quill.import('formats/List');

class WinkList extends List {
    static create(value) {
        let node = super.create(value);

        node.setAttribute('class', 'list-disc');

        return node;
    }
}

export default WinkList
