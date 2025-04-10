import { Link, Head, useForm } from "@inertiajs/react";
import Swal from "sweetalert2";
import { useState } from "react";
import { Inertia } from "@inertiajs/inertia";
import Sidebar from "@/Components/Admin/Sidebar";
import Navbar from "@/Components/Navbar/Navbar";

const CreateHeroFaq = ({ auth }) => {
    const { data, setData, post, processing, errors } = useForm({
        question: "",
        answer: "",
    });
    const [activeMenu, setActiveMenu] = useState("hero-faq");
    const user = auth.user;

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append("question", data.question);
        formData.append("answer", data.answer);

        post("/hero-faq", {
            data: formData,
            onSuccess: () => {
                Swal.fire({
                    title: "Success!",
                    text: "Hero Faq has been added successfully.",
                    icon: "success",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#000000",
                    scrollbarPadding: false,
                    backdrop: false,
                }).then(() => {
                    Inertia.visit("/hero-faq");
                });
            },
            onError: () => {
                Swal.fire({
                    title: "Error!",
                    text: "There was an error adding the Hero Faq.",
                    icon: "error",
                    confirmButtonText: "OK",
                    confirmButtonColor: "#000000",
                    scrollbarPadding: false,
                    backdrop: false,
                });
            },
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
                <Head title="Create Hero Faq | PT Ratu Bio Indonesia" />
                <Navbar auth={auth} />
                {/* Breadcrumb */}
                <nav className="mb-4 flex items-center space-x-2 font-lexend text-sm text-gray-600">
                    <Link href="/dashboard" className="hover:text-black hover:underline">
                        Dashboard
                    </Link>
                    <span className="text-gray-400">/</span>
                    <Link
                        href="/hero-faq"
                        className="hover:text-black hover:underline"
                    >
                        Manage Hero Faq
                    </Link>
                    <span className="text-gray-400">/</span>
                    <span className="font-bold text-black">
                        Create Hero Faq
                    </span>
                </nav>
                {/* Title */}
                <h2 className="mb-4 font-lexend text-xl font-bold">
                    Create Home Page Content
                </h2>
                {/* Form */}
                <form
                    onSubmit={handleSubmit}
                    className="mx-auto w-full max-w-screen-lg space-y-4"
                    encType="multipart/form-data"
                >
                    <div>
                        <label
                            htmlFor="question"
                            className="block font-lexend text-sm font-medium text-gray-700"
                        >
                            Question
                        </label>
                        <input
                            id="question"
                            type="text"
                            value={data.question}
                            onChange={(e) => setData("question", e.target.value)}
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm"
                            required
                        />
                        {errors.question && (
                            <span className="text-sm text-red-600">{errors.question}</span>
                        )}
                    </div>
                    <div>
                        <label
                            htmlFor="answer"
                            className="block font-lexend text-sm font-medium text-gray-700"
                        >
                            Answer
                        </label>
                        <textarea
                            id="answer"
                            value={data.answer}
                            onChange={(e) => setData("answer", e.target.value)}
                            className="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm"
                            rows="4"
                            required
                        />
                        {errors.answer && (
                            <span className="text-sm text-red-600">{errors.answer}</span>
                        )}
                    </div>
                    <button
                        type="submit"
                        disabled={processing}
                        className="w-full rounded-md bg-custom-yellow px-6 py-2 font-lexend font-semibold text-black hover:bg-yellow-600 sm:w-auto"
                    >
                        {processing ? "Saving..." : "Save Hero Faq"}
                    </button>
                </form>
            </div>
        </div>
    );
};

export default CreateHeroFaq;
