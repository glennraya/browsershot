import { useState, PropsWithChildren, ReactNode } from 'react'
import { HomeIcon, InboxIcon, DocIcon } from '@/Components/Icons'
import { User } from '@/types'
import NavLink from '@/Components/NavLink'
import ProfileDropdown from '@/Components/ProfileDropdown'

export default function Authenticated({
    user,
    children
}: PropsWithChildren<{ user: User; header?: ReactNode }>) {
    return (
        <div className="relative flex h-screen">
            <div className="fixed inset-y-0 left-0 hidden flex-grow md:flex">
                <div className="flex w-80 flex-grow flex-col gap-y-8">
                    <div className="flex flex-grow flex-col justify-between gap-y-8">
                        <nav className="flex flex-col">
                            <h1 className="p-6 text-xl font-bold dark:text-white">
                                ProPDF Docs
                            </h1>

                            <div className="flex flex-col gap-y-2 border-t border-gray-300 px-4 pt-8 font-medium dark:border-gray-900">
                                <NavLink
                                    href={route('dashboard')}
                                    active={route().current('dashboard')}
                                    className="flex items-center gap-2"
                                >
                                    <HomeIcon />
                                    <span className="pt-1">Home</span>
                                </NavLink>
                                <NavLink
                                    href={``}
                                    active={route().current('inbox')}
                                    className="flex items-center gap-2"
                                >
                                    <InboxIcon />
                                    <span>Inbox</span>
                                </NavLink>
                                <NavLink
                                    href={``}
                                    active={route().current('reports')}
                                    className="flex items-center gap-2"
                                >
                                    <DocIcon />
                                    <span>Reports</span>
                                </NavLink>
                            </div>
                        </nav>

                        <ProfileDropdown user={user} />
                    </div>
                </div>
            </div>

            <main className="my-3 ml-0 mr-3 flex w-full rounded-xl border border-gray-200 bg-white shadow-sm md:ml-80 dark:border-gray-800 dark:bg-gray-800 dark:shadow-none">
                {children}
            </main>
        </div>
    )
}
