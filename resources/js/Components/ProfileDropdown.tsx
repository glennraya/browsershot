import { router } from '@inertiajs/react'
import {
    Dropdown,
    DropdownTrigger,
    DropdownMenu,
    DropdownItem,
    User,
    Link
} from '@nextui-org/react'
import { User as UserProp } from '@/types'

const ProfileDropdown = ({ user }: { user: UserProp }) => {
    return (
        <div className="flex items-center gap-4 px-4 pb-4">
            <Dropdown
                placement="bottom-start"
                className="dark:bg-gray-900 dark:text-white"
            >
                <DropdownTrigger>
                    <User
                        as="button"
                        avatarProps={{
                            src: `https://ui-avatars.com/api/?size=256&name=${user.name}`
                        }}
                        className="text-2xl transition-transform dark:text-white"
                        description={
                            <span className="text-sm">{user.email}</span>
                        }
                        name={
                            <Link
                                size="md"
                                className="text-black dark:text-white"
                            >
                                {user.name}
                            </Link>
                        }
                    />
                </DropdownTrigger>
                <DropdownMenu aria-label="User Actions" variant="flat">
                    <DropdownItem
                        key="profile"
                        className="h-14 gap-2"
                        textValue={`User's email address`}
                    >
                        <p className="font-bold">Signed in as</p>
                        <p className="font-bold">{user.email}</p>
                    </DropdownItem>
                    <DropdownItem key="configurations">Settings</DropdownItem>
                    <DropdownItem key="help_and_feedback">
                        Help & Feedback
                    </DropdownItem>
                    <DropdownItem
                        key="logout"
                        color="danger"
                        onPress={() => {
                            router.post('/logout')
                        }}
                    >
                        Log Out
                    </DropdownItem>
                </DropdownMenu>
            </Dropdown>
        </div>
    )
}

export default ProfileDropdown
