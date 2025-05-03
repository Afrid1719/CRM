import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router } from "@inertiajs/react";
import Pagination from "@/Components/Pagination";
import ClientsTableRow from "@/Components/ClientsTableRow";
import { useCallback, useEffect, useRef, useState } from "react";

export default function Index({ auth, page, filters }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Clients
                </h2>
            }
        >
            <Head title="Clients" />

            <div className="py-12">
                <div className="max-w-8xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg">
                        <ClientsHeader
                            search={filters.search || ""}
                            active={filters.active || "active"}
                        />

                        <div className="p-4 pt-0 px-0 overflow-auto">
                            <table className="w-full min-w-max table-auto text-left">
                                <thead>
                                    <tr>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                Name
                                            </p>
                                        </th>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                Email
                                            </p>
                                        </th>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                VAT
                                            </p>
                                        </th>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                Address
                                            </p>
                                        </th>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-between gap-2 font-normal leading-none opacity-70">
                                                Active
                                            </p>
                                        </th>
                                        <th className="cursor-pointer border-y border-blue-gray-100 bg-blue-gray-50/50 p-4 transition-colors hover:bg-blue-gray-50 ">
                                            <p className="antialiased font-sans text-sm text-blue-gray-900 flex items-center justify-end gap-2 font-normal leading-none opacity-70">
                                                Actions
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {page.data.length > 0 &&
                                        page.data.map((client) => (
                                            <ClientsTableRow
                                                key={client.id}
                                                client={client}
                                            />
                                        ))}
                                    {page.data.length === 0 && (
                                        <tr>
                                            <td
                                                colSpan="6"
                                                className="text-center p-4"
                                            >
                                                No clients found.
                                            </td>
                                        </tr>
                                    )}
                                </tbody>
                            </table>
                            <Pagination
                                prevUrl={page.prev_page_url}
                                nextUrl={page.next_page_url}
                                links={page.links}
                            />
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}

function ClientsHeader({ search, active }) {
    const [activeFilter, setActiveFilter] = useState(active);
    const [searchQuery, setSearchQuery] = useState(search);
    const [isFetching, setIsFetching] = useState(false);

    const didMount = useRef(false);

    const fetchClients = useCallback(async () => {
        setIsFetching(true);
        router.get(
            route("clients.index"),
            {
                search: searchQuery,
                active: activeFilter
            },
            {
                preserveState: true,
                preserveScroll: true,
                replace: true,
                onFinish: () => {
                    setIsFetching(false);
                }
            }
        );
    }, [searchQuery, activeFilter]);

    useEffect(() => {
        if (!didMount.current) {
            didMount.current = true;
            return;
        }

        const handler = setTimeout(() => {
            fetchClients();
        }, 500);

        return () => {
            clearTimeout(handler);
        };
    }, [searchQuery, activeFilter]);

    const activeFilterChange = (e) => setActiveFilter(e.target.value);

    const handleSearchChange = (e) => setSearchQuery(e.target.value);

    return (
        <div className="w-full flex flex-col sm:flex-row sm:justify-end sm:items-center gap-4 p-3">
            <input
                type="text"
                placeholder="Search Clients..."
                className="p-2 border border-indigo-600 text-black rounded-md text-sm min-w-48 disabled:bg-gray-50"
                onChange={handleSearchChange}
                value={searchQuery}
            />
            <div className="flex flex-row justify-between gap-4 items-center">
                <select
                    className="p-2 border border-indigo-600 rounded-md text-sm bg-gray-50 text-black w-3/5 sm:w-32"
                    onChange={activeFilterChange}
                    value={activeFilter}
                    disabled={isFetching}
                >
                    <option value="all">All</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <Link
                    href={route("clients.create")}
                    className="inline-block p-2 border border:border-gray-800 dark:border-white rounded-md font-normal font-sans text-sm"
                >
                    Add Client
                </Link>
            </div>
        </div>
    );
}
