import { Link, Head, useForm } from "@inertiajs/react";
import Swal from "sweetalert2";
import { useState } from "react";
import { IoAdd, IoPencil, IoTrash } from "react-icons/io5";
import Sidebar from "@/Components/Admin/Sidebar";
import Navbar from "@/Components/Navbar/Navbar";

const ManageHeroFaq = ({ dataHeroFaq, auth }) => {
    const { delete: deleteRecord } = useForm();
    const [activeMenu, setActiveMenu] = useState("hero-faq");
    const user = auth.user;

    const handleDelete = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
            confirmButtonColor: "#000000",
            scrollbarPadding: false,
            backdrop: false,
        }).then((result) => {
            if (result.isConfirmed) {
                deleteRecord(`/hero-faq/${id}`, {
                    method: "DELETE",
                });
                Swal.fire({
                    title: "Deleted!",
                    text: "Your file has been deleted.",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#000000",
                    scrollbarPadding: false,
                    backdrop: false,
                });
            }
        });
    };

    return (
        <div className="flex min-h-screen bg-gray-100">
            {/* Sidebar */}
            {auth && (
                <Sidebar
                    auth={auth}
                    activeMenu={activeMenu}
                    setActiveMenu={setActiveMenu}
                />
            )}

            {/* Main Content */}
            <div className="mt-16 flex-1 bg-neutral-50 p-6">
                <Head title="Manage Hero Faq | PT Ratu Bio Indonesia" />
                <Navbar auth={auth} />

                {/* Breadcrumb */}
                <nav className="mb-4 flex items-center space-x-2 font-lexend text-sm text-gray-600">
                    <Link href="/dashboard" className="hover:text-black hover:underline">
                        Dashboard
                    </Link>
                    <span className="text-gray-400">/</span>
                    <span className="font-bold text-black">Manage Hero Faq</span>
                </nav>

                {/* Title */}
                <h2 className="mb-4 font-lexend text-xl font-bold">
                    Home Page Content
                </h2>

                {/* Add Button */}
                <div className="mb-6 flex justify-end">
                    <Link
                        href="/hero-faq/create"
                        className="rounded bg-custom-yellow p-2 text-black hover:bg-yellow-500"
                    >
                        <IoAdd size={24} />
                    </Link>
                </div>

                {/* Table for Desktop */}
                <div className="hidden md:block">
                    <table className="min-w-full divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow-md">
                        <thead>
                            <tr>
                                <th className="px-6 py-3 text-center font-lexend text-xs font-medium uppercase tracking-wider text-gray-500">
                                    ID
                                </th>
                                <th className="px-6 py-3 text-center font-lexend text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Question
                                </th>
                                <th className="px-6 py-3 text-center font-lexend text-xs font-medium uppercase tracking-wider text-gray-500">
                                    Answer
                                </th>
                            </tr>
                        </thead>
                        <tbody className="divide-y divide-gray-200 bg-white">
                            {dataHeroFaq.map((heroFaq) => (
                                <tr key={heroFaq.id}>
                                    <td className="max-w-[150px] truncate whitespace-nowrap px-4 py-4 text-center font-lexend text-sm text-gray-700">
                                        {heroFaq.id}
                                    </td>
                                    <td className="max-w-[150px] truncate whitespace-nowrap px-4 py-4 text-center font-lexend text-sm text-gray-700">
                                        {heroFaq.question}
                                    </td>
                                    <td className="max-w-[150px] truncate whitespace-nowrap px-4 py-4 text-center font-lexend text-sm text-gray-700">
                                        {heroFaq.answer}
                                    </td>
                                    <td className="flex flex-col items-center justify-center space-y-2 whitespace-nowrap px-4 py-3 font-lexend text-sm font-medium">
                                        {/* Edit Button */}
                                        <Link
                                            href={`/hero-faq/${heroFaq.id}/edit`}
                                            className="text-indigo-600 hover:text-indigo-900"
                                        >
                                            <IoPencil size={20} />
                                        </Link>
                                        {/* Delete Button */}
                                        <button
                                            onClick={() => handleDelete(heroFaq.id)}
                                            className="text-red-600 hover:text-red-900"
                                        >
                                            <IoTrash size={20} />
                                        </button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                {/* Mobile View */}
                <div className="block md:hidden">
                    {dataHeroFaq.map((heroFaq) => (
                        <div
                            key={heroFaq.id}
                            className="mb-4 rounded-lg bg-white p-4 shadow-md"
                        >
                            <div className="flex justify-between">
                                <h3 className="font-lexend text-base font-bold text-gray-800">
                                    {heroFaq.question}
                                </h3>
                                <div className="flex items-center space-x-2">
                                    <button
                                        onClick={() => handleDelete(heroFaq.id)}
                                        className="text-red-600 hover:text-red-900"
                                    >
                                        <IoTrash size={20} />
                                    </button>
                                </div>
                            </div>
                            <p className="mt-2 font-lexend text-sm text-gray-600">
                                <strong>Question:</strong> {heroFaq.question}
                            </p>
                            <p className="mt-2 font-lexend text-sm text-gray-600">
                                <strong>Answer:</strong> {heroFaq.answer}
                            </p>
                        </div>
                    ))}
                </div>
            </div>
        </div>
    );
};

export default ManageHeroFaq;
