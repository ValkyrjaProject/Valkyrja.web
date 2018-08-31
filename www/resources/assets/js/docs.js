import SmoothScroll from "smoothscroll";

export default function initSubHeaders() {
    const sidebar = document.querySelector(".docs-navigation-container");
    const content = document.getElementById("docs-navigation");
    const documentation = document.querySelector(".docs-content");

    if (documentation === null) {
        return;
    }

    const startNavHeight = content.offsetTop;

    let currentPageAnchor = sidebar.querySelector(".sidebar-link.current");

    var allHeaders = [];

    let headers = documentation.querySelectorAll("h1");

    if (headers.length) {
        headers.forEach(function (h) {
            h.id = slugize(h.innerHTML.toString());
            content.appendChild(makeLink(h));
            let h2s = collectH2s(h);

            allHeaders.push(h);
            allHeaders.push.apply(allHeaders, h2s);

            if (h2s.length) {
                content.appendChild(makeSubLinks(h2s));
            }
        });
    }

    let animating = false;

    sidebar.addEventListener("click", (e) => {
        if (e.target.classList.contains("section-link")) {
            //sidebar.classList.remove('open'); // mobile - hide once clicked
            setActive(e.target);
            animating = true;
            setTimeout(function () {
                animating = false;
            }, 400);
        }
    }, true);
    allHeaders.forEach(makeHeaderClickable);

    let hoveredOverSidebar = false;

    sidebar.addEventListener("mouseover", () => hoveredOverSidebar = true);
    sidebar.addEventListener("mouseleave", () => hoveredOverSidebar = false);

    window.addEventListener("scroll", updateSidebar);
    window.addEventListener("resize", updateSidebar);

    window.addEventListener("scroll", stickyNavigation);
    window.addEventListener("resize", stickyNavigation);

    window.addEventListener("scroll", setStickySize);
    window.addEventListener("resize", setStickySize);

    function updateSidebar() {
        let doc = document.documentElement;
        let top = doc && doc.scrollTop || document.body.scrollTop;
        if (animating || !allHeaders) return;
        let last;
        for (let i = 0; i < allHeaders.length; i++) {
            let link = allHeaders[i];
            // TODO: link.offsetTop is always 0, as well as getBoundingClientRect().top
            if (link.offsetTop > top) {
                if (!last) last = link;
                break;
            } else {
                last = link;
            }
        }
        if (last)
            setActive(last.id, !hoveredOverSidebar);
    }


    function escapeRegExp(str) {
        if (typeof str !== "string") throw new TypeError("str must be a string!");

        // http://stackoverflow.com/a/6969486
        return str.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&");
    }

    function slugize(str, options) {
        if (typeof str !== "string") throw new TypeError("str must be a string!");
        options = options || {};

        let rControl = /[\u0000-\u001f]/g;
        let rSpecial = /[\s~`!@#\$%\^&\*\(\)\-_\+=\[\]\{\}\|\\;:"'<>,\.\?\/]+/g;
        let separator = options.separator || "-";
        let escapedSep = escapeRegExp(separator);

        let result = str
        // Remove control characters
            .replace(rControl, "")
            // Replace special characters
            .replace(rSpecial, separator)
            // Remove continuous separators
            .replace(new RegExp(escapedSep + "{2,}", "g"), separator)
            // Remove prefixing and trailing separators
            .replace(new RegExp("^" + escapedSep + "+|" + escapedSep + "+$", "g"), "");

        switch (options.transform) {
        case 1:
            return result.toLowerCase();
        case 2:
            return result.toUpperCase();
        default:
            return result;
        }
    }

    function collectH2s(h) {
        let h2s = [];
        let next = h.nextSibling;

        while (next && next.tagName !== "H1") {
            if (next.tagName === "H2") {
                next.id = slugize(next.innerHTML.toString());
                h2s.push(next);
            }
            else if (next.tagName === "DIV") {
                let nextChild = next.children[0];
                while (nextChild && nextChild.tagName !== "H1") {
                    if (nextChild.tagName === "H2") {
                        nextChild.id = slugize(nextChild.innerHTML.toString());
                        h2s.push(nextChild);
                    }
                    nextChild = nextChild.nextSibling;
                }
            }
            next = next.nextSibling;
        }
        return h2s;
    }

    function makeHeaderClickable(header) {
        header.setAttribute("data-scroll", "");

        // transform DOM structure from
        // `<h1><a></a>Header</a>` to <h1><a>Header</a></h1>`
        // to make the header clickable
        let nodes = Array.prototype.slice.call(header.childNodes);
        for (let i = 0; i < nodes.length; i++) {
            let node = nodes[i];
            if (node !== header) {
                header.appendChild(node);
            }
        }
    }

    function makeSubLinks(h2s) {
        let container = document.createElement("ul");
        h2s.forEach((h) => {
            container.appendChild(makeLink(h));
        });
        return container;
    }

    function makeLink(h) {
        let link = document.createElement("li");
        window.arst = h;
        let text = [].slice.call(h.childNodes).map(function (node) {
            if (node.nodeType === Node.TEXT_NODE) {
                return node.nodeValue;
            } else if (["CODE", "SPAN"].indexOf(node.tagName) !== -1) {
                return node.textContent;
            } else {
                return "";
            }
        }).join("").replace(/\(.*\)$/, "");
        link.innerHTML =
            "<a class=\"section-link\" data-scroll href=\"#" + h.id + "\">" +
            htmlEscape(text) +
            "</a>";
        return link;
    }

    function setActive(id, shouldScrollIntoView) {
        let content = document.getElementById("docs-navigation");
        let previousActive = content.querySelector(".section-link.is-active");
        let currentActive = typeof id === "string"
            ? content.querySelector(".section-link[href=\"#" + id + "\"]")
            : id;
        if (currentActive !== previousActive) {
            if (previousActive) previousActive.classList.remove("is-active");
            currentActive.classList.add("is-active");
            if (shouldScrollIntoView) {
                let currentPageOffset = currentPageAnchor
                    ? currentPageAnchor.offsetTop - 8
                    : 0;
                let currentActiveOffset = currentActive.offsetTop + currentActive.parentNode.clientHeight;
                let sidebarHeight = content.clientHeight;
                let currentActiveIsInView = (
                    currentActive.offsetTop >= content.scrollTop &&
                    currentActiveOffset <= content.scrollTop + sidebarHeight
                );
                let linkNotFurtherThanSidebarHeight = currentActiveOffset - currentPageOffset < sidebarHeight;
                content.scrollTop = currentActiveIsInView
                    ? content.scrollTop
                    : linkNotFurtherThanSidebarHeight
                        ? currentPageOffset
                        : currentActiveOffset - sidebarHeight;
            }
        }
    }

    function htmlEscape(text) {
        return text
            .replace(/&/g, "&amp;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#39;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;");
    }

    function stickyNavigation() {
        let content = document.getElementById("docs-navigation");
        if (window.scrollY >= startNavHeight) {
            content.style.width = content.offsetWidth + "px";
            content.style.left = content.offsetLeft + "px";
            content.classList.add("fixed-nav");
        } else {
            content.classList.remove("fixed-nav");
        }
    }

    function setStickySize() {
        let content = document.getElementById("docs-navigation");
        let app = document.getElementById("app");

        if (window.scrollY < startNavHeight) {
            content.style.height = (window.innerHeight - content.offsetTop + window.scrollY) + "px";
        }
        else if ((window.scrollY + window.innerHeight) > app.offsetHeight) {
            // TODO: elseif not fully correct, off by a few px. height is also wrong
            content.style.top = "0";
            content.style.height = (app.offsetHeight - window.scrollY + 30) + "px";
        }
        else {
            content.style.height = window.innerHeight + "px";
        }
    }
}
