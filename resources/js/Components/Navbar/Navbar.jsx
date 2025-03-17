import { useState, useEffect } from "react";
import { Link, usePage } from "@inertiajs/react";
import Dropdown from "@/Components/Dropdown";
import { FaChevronDown } from "react-icons/fa";
import { RiShoppingBagLine } from "react-icons/ri";
import Notification from "../Admin/Notification";

export default function Navbar({ auth }) {
  const [isScrolled, setIsScrolled] = useState(false);
  const [menuOpen, setMenuOpen] = useState(false);
  const [cartItems, setCartItems] = useState(0);
  const { url } = usePage();
  const user = auth?.user;

  useEffect(() => {
    if (user) {
      fetchCartItems();
    }
    const handleCartUpdate = () => {
      fetchCartItems();
    };
    window.addEventListener("cartUpdated", handleCartUpdate);
    return () => {
      window.removeEventListener("cartUpdated", handleCartUpdate);
    };
  }, [user]);

  const fetchCartItems = async () => {
    try {
      const response = await fetch("/cart/items", {
        method: "GET",
        headers: {
          Accept: "application/json",
          "Content-Type": "application/json",
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content"),
        },
        credentials: "include",
      });
      if (!response.ok) {
        throw new Error(
          `Failed to fetch cart items: ${response.status} ${response.statusText}`,
        );
      }
      const data = await response.json();
      setCartItems(data.length);
    } catch (error) {
      console.error("Failed to fetch cart items:", error);
    }
  };

  const menuItems = [
    { name: "Home", path: "/" },
    { name: "About", path: "/about" },
    { name: "Product", path: "/product" },
    { name: "Order", path: "/order" },
    { name: "Chat", path: "/chatify" },
  ];

  return (
    <nav
      className={`fixed left-0 top-0 z-50 w-full shadow-md transition-colors duration-300 ${
        isScrolled ? "bg-white text-gray-800" : "text-base-content bg-white"
      }`}
    >
      <div className="container relative mx-auto flex items-center justify-between px-4 py-2 md:px-8">
        {/* Logo */}
        <img
          className="flex w-14 items-center md:w-14"
          src="/Navbar/NavbarLogo.png"
          alt="Logo"
        />

        {/* Navigation Links */}
        <div className="hidden md:flex md:gap-2">
          {menuItems.map(({ name, path }) => (
            <Link
              key={path}
              href={path}
              className={`rounded-lg px-4 py-2 font-lexend text-sm text-gray-700 transition-all duration-300 hover:text-black ${
                url === path ||
                (path === "/product" && url.startsWith("/product"))
                  ? "font-semibold text-black"
                  : ""
              }`}
            >
              {name}
            </Link>
          ))}
        </div>

        {/* Right Section (Icons and Profile) */}
        <div className="flex items-center gap-2">
          {/* Notification Icon */}
          <div
            className={`relative flex items-center justify-center rounded-full p-1 transition-all duration-300 ${
              url === "/notifications"
                ? "bg-gray-100 text-black"
                : "hover:bg-gray-100"
            }`}
          >
            <Notification className="h-6 w-6 text-gray-700" />
          </div>

          {/* Cart Icon */}
          <Link
            href="/cart"
            className={`relative flex items-center justify-center rounded-full p-1 transition-all duration-300 ${
              url === "/cart" ? "bg-gray-100 text-black" : "hover:bg-gray-100"
            }`}
          >
            <RiShoppingBagLine className="h-6 w-6 font-lexend text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none" />
            {cartItems > 0 && (
              <span className="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs text-white">
                {cartItems}
              </span>
            )}
          </Link>

          {/* Jika user belum login, tampilkan Register & Login */}
          {!user && url !== "" && (
            <div className="hidden md:flex md:items-center md:gap-2">
              <Link
                href="/register"
                className="px-3 py-1 font-lexend text-sm text-gray-700 transition-all duration-300 hover:text-black"
              >
                Register
              </Link>
              <Link
                href="/login"
                className="px-3 py-1 font-lexend text-sm text-gray-700 transition-all duration-300 hover:text-black"
              >
                Login
              </Link>
            </div>
          )}

          {/* Jika user sudah login, tampilkan dropdown profil */}
          {user && (
            <div className="relative">
              <Dropdown>
                <Dropdown.Trigger>
                  <button
                    type="button"
                    className="inline-flex items-center rounded-md border border-transparent px-3 py-2 font-lexend text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                  >
                    {/* {user?.name} */}
                    {user.name.split(" ").slice(0, 2).join(" ")} 
                    <img
                      src={`/storage/avatars/${auth.user.id}.png`}
                      alt={auth.user.name}
                      className="mx-2 h-10 w-10 rounded-full border border-custom-yellow"
                    />
                    <FaChevronDown
                      className="ml-2 h-2 w-2"
                      aria-hidden="true"
                    />
                  </button>
                </Dropdown.Trigger>
                <Dropdown.Content>
                  <Dropdown.Link href="/dashboard" className="font-lexend">
                    Dashboard
                  </Dropdown.Link>
                  <Dropdown.Link
                    href={route("profile.edit")}
                    className="font-lexend"
                  >
                    Profile
                  </Dropdown.Link>
                  <Dropdown.Link
                    href={route("logout")}
                    className="font-lexend"
                    method="post"
                    as="button"
                  >
                    Log Out
                  </Dropdown.Link>
                </Dropdown.Content>
              </Dropdown>
            </div>
          )}
        </div>

        {/* Mobile Menu Button */}
        <div className="flex items-center md:hidden">
          <button
            className="text-gray-700 focus:outline-none"
            onClick={() => setMenuOpen(!menuOpen)}
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              className="h-6 w-6"
              fill="none"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>

        {/* Mobile Menu */}
        {menuOpen && (
          <ul className="absolute left-0 right-0 top-14 z-50 mt-2 rounded-md bg-white p-4 text-gray-800 shadow-lg md:hidden">
            {menuItems.map(({ name, path }) => (
              <li key={path}>
                <Link
                  href={path}
                  className={`block px-4 py-2 ${
                    url === path ||
                    (url.startsWith("/product") && path === "/product")
                      ? "font-bold"
                      : "font-regular"
                  } font-lexend hover:bg-gray-100`}
                  onClick={() => setMenuOpen(false)}
                >
                  {name}
                </Link>
              </li>
            ))}
          </ul>
        )}
      </div>
    </nav>
  );
}
