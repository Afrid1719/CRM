import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import Checkbox from "@/Components/Checkbox";
import { Switch, Transition } from "@headlessui/react";

export default function Create({ auth, client = null }) {
    const { data, setData, post, put, processing, errors, recentlySuccessful } =
        useForm({
            name: client?.name || "",
            vat: client?.vat || "",
            address: client?.address || "",
            email: client?.email || "",
            isActive: client?.isActive || true
        });

    const submit = (e) => {
        e.preventDefault();

        if (client) {
            put(route("clients.update", { client: client.id }));
        } else {
            post(route("clients.store"));
        }
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Clients
                </h2>
            }
        >
            {client ? (
                <Head title="Edit Client" />
            ) : (
                <Head title="Create Client" />
            )}

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg">
                        <div className="w-full flex justify-end p-3">
                            <Link
                                as="button"
                                href={route("clients.index")}
                                className="p-2 border border:border-gray-800 dark:border-white rounded-md font-normal font-sans text-sm"
                            >
                                All Clients
                            </Link>
                        </div>
                        <div className="p-4">
                            <div className="flex my-4">
                                <h2 className="inline-block font-normal font-sans text-lg py-1 border-b">
                                    {client
                                        ? `Edit Client - ${client.name}`
                                        : "Create Client"}
                                </h2>
                                <div className="inline-block p-2 text-green-600">
                                    <Transition
                                        show={recentlySuccessful}
                                        enter="transition ease-in-out"
                                        enterFrom="opacity-0"
                                        leave="transition ease-in-out"
                                        leaveTo="opacity-0"
                                    >
                                        <div className="flex items-center gap-x-1">
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                x="0px"
                                                y="0px"
                                                width="100"
                                                height="100"
                                                viewBox="0 0 48 48"
                                                className="w-6 h-6"
                                            >
                                                <path
                                                    fill="#c8e6c9"
                                                    d="M44,24c0,11.045-8.955,20-20,20S4,35.045,4,24S12.955,4,24,4S44,12.955,44,24z"
                                                ></path>
                                                <path
                                                    fill="#4caf50"
                                                    d="M34.586,14.586l-13.57,13.586l-5.602-5.586l-2.828,2.828l8.434,8.414l16.395-16.414L34.586,14.586z"
                                                ></path>
                                            </svg>
                                            {"Saved"}
                                        </div>
                                    </Transition>
                                </div>
                            </div>
                            <form onSubmit={submit}>
                                <section className="max-w-xl">
                                    <div>
                                        <InputLabel
                                            htmlFor="name"
                                            value="Name"
                                        />

                                        <TextInput
                                            id="name"
                                            name="name"
                                            value={data.name}
                                            className="mt-1 block w-full"
                                            autoComplete="name"
                                            isFocused={true}
                                            onChange={(e) => {
                                                setData("name", e.target.value);
                                            }}
                                            required
                                        />

                                        <InputError
                                            message={errors.name}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mt-4">
                                        <InputLabel
                                            htmlFor="email"
                                            value="Email"
                                        />

                                        <TextInput
                                            id="email"
                                            name="email"
                                            type="email"
                                            value={data.email}
                                            className="mt-1 block w-full disabled:opacity-50"
                                            autoComplete="email"
                                            onChange={(e) =>
                                                setData("email", e.target.value)
                                            }
                                            required
                                            disabled={!!client}
                                        />

                                        <InputError
                                            message={errors.email}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mt-4">
                                        <InputLabel htmlFor="vat" value="VAT" />

                                        <TextInput
                                            id="vat"
                                            name="vat"
                                            type="number"
                                            max="999999"
                                            value={data.vat}
                                            className="mt-1 block w-full disabled:opacity-50"
                                            autoComplete="vat"
                                            onChange={(e) =>
                                                setData("vat", e.target.value)
                                            }
                                            required
                                        />

                                        <InputError
                                            message={errors.vat}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mt-4">
                                        <InputLabel
                                            htmlFor="address"
                                            value="Address"
                                        />

                                        <TextInput
                                            id="address"
                                            type="text"
                                            name="address"
                                            value={data.address}
                                            className="mt-1 block w-full"
                                            onChange={(e) =>
                                                setData(
                                                    "address",
                                                    e.target.value
                                                )
                                            }
                                        />

                                        <InputError
                                            message={errors.address}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="flex flex-row items-center mt-4">
                                        <InputLabel
                                            htmlFor="isActive"
                                            value="Active"
                                            className="cursor-pointer mr-2"
                                        />
                                        <Switch
                                            title={`${
                                                data.isActive
                                                    ? "Active"
                                                    : "Inactive"
                                            }`}
                                            checked={data.isActive}
                                            onChange={(e) => {
                                                setData("isActive", e);
                                            }}
                                            className={`${
                                                data.isActive
                                                    ? "bg-indigo-600"
                                                    : "bg-gray-300"
                                            } relative inline-flex h-6 w-11 items-center rounded-full`}
                                        >
                                            <span className="sr-only">
                                                Activate Client
                                            </span>
                                            <span
                                                className={`${
                                                    data.isActive
                                                        ? "translate-x-6"
                                                        : "translate-x-1"
                                                } inline-block h-4 w-4 transform rounded-full bg-white transition`}
                                            />
                                        </Switch>
                                    </div>
                                </section>
                                <div className="flex items-center justify-end mt-4">
                                    <PrimaryButton
                                        className="ms-4"
                                        disabled={processing}
                                    >
                                        Save
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
