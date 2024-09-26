import { Link } from "@inertiajs/react";

export default function Pagination({ prevUrl, nextUrl, links }) {
    return (
        <div className="flex mx-auto justify-center mt-4 gap-x-3">
            {prevUrl && (
                <Link
                    href={prevUrl}
                    className="px-2 py-1 text-white bg-blue-400 rounded text-sm"
                >
                    <span
                        dangerouslySetInnerHTML={{
                            __html: links[0].label
                        }}
                    ></span>
                </Link>
            )}
            {links.slice(1, links.length - 1).map((link, idx) => (
                <Link
                    key={`${idx}-${link.url}`}
                    href={link.url}
                    className={`px-2 py-1 text-white rounded text-sm ${
                        link.active ? "bg-blue-600" : "bg-blue-400"
                    }`}
                >
                    {link.label}
                </Link>
            ))}
            {nextUrl && (
                <Link
                    href={nextUrl}
                    className="px-2 py-1 text-white bg-blue-400 rounded text-sm"
                >
                    <span
                        dangerouslySetInnerHTML={{
                            __html: links[links.length - 1].label
                        }}
                    ></span>
                </Link>
            )}
        </div>
    );
}
