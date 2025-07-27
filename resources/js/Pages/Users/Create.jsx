import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, router, useForm } from "@inertiajs/react";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import PrimaryButton from "@/Components/PrimaryButton";
import TextInput from "@/Components/TextInput";
import Permissions from "@/Components/Permissions";
import { useRoles } from "@/Context/RolesContext";
import Radio from "@/Components/Radio";
import { Transition } from "@headlessui/react";

export default function Create({ auth, permissions, actions, user = null }) {
    const { data, setData, post, put, processing, errors, recentlySuccessful } =
        useForm({
            avatar: user?.avatar || "",
            name: user?.name || "",
            email: user?.email || "",
            role: user?.role || 1
        });

    const { roles } = useRoles();

    const submit = (e) => {
        e.preventDefault();

        if (user) {
            put(route("users.update", { user: user.id }));
        } else {
            post(route("users.store"));
        }
    };
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={
                <h2 className="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Users
                </h2>
            }
        >
            {user ? <Head title="Edit User" /> : <Head title="Create User" />}

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6 flex flex-col gap-4">
                    <div className="bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow-sm sm:rounded-lg">
                        <div className="w-full flex justify-end p-3">
                            <Link
                                as="button"
                                href={route("users.index")}
                                className="p-2 border border:border-gray-800 dark:border-white rounded-md font-normal font-sans text-sm"
                            >
                                All Users
                            </Link>
                        </div>
                        <div className="p-4">
                            <div className="flex my-4">
                                <h2 className="inline-block font-normal font-sans text-lg py-1 border-b">
                                    {user
                                        ? `Edit User - ${user.name}`
                                        : "Create User"}
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
                                            Saved
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
                                            disabled={!!user}
                                        />

                                        <InputError
                                            message={errors.email}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mt-4">
                                        <InputLabel
                                            htmlFor="avatar"
                                            value="Avatar Url"
                                        />

                                        <TextInput
                                            id="avatar"
                                            type="url"
                                            name="avatar"
                                            value={data.avatar}
                                            className="mt-1 block w-full"
                                            onChange={(e) =>
                                                setData(
                                                    "avatar",
                                                    e.target.value
                                                )
                                            }
                                        />

                                        <InputError
                                            message={errors.avatar}
                                            className="mt-2"
                                        />
                                    </div>

                                    <div className="mt-4">
                                        <div className="block font-medium text-sm text-gray-700 dark:text-gray-300 ">
                                            Role
                                        </div>
                                        <div className="mt-2 flex space-x-2">
                                            {roles.map((role, idx) => (
                                                <Radio
                                                    key={role}
                                                    name="role"
                                                    value={idx}
                                                    checked={data.role === idx}
                                                    onChange={(e) =>
                                                        setData(
                                                            "role",
                                                            Number(
                                                                e.target.value
                                                            )
                                                        )
                                                    }
                                                >
                                                    {role}
                                                </Radio>
                                            ))}
                                        </div>

                                        <InputError
                                            message={errors.role}
                                            className="mt-2"
                                        />
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
                    <Permissions
                        permissions={permissions}
                        actions={actions}
                        user={user}
                    />
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
