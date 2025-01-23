<script>
    import EmployeeList from "../../components/EmployeeList.svelte";
    import Searchbar from "../../components/Searchbar.svelte";

    let data = {
        employees: [
            {
                firstName: 'Jan',
                lastName: 'Kowalski',
                email: 'j.kowalski@company.com',
                jobTitle: 'Android Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2022-01-15'
            },
            {
                firstName: 'Anna',
                lastName: 'Nowak',
                email: 'a.nowak@company.com',
                jobTitle: 'UI Designer',
                groups: [{name: 'Design'}],
                employedSince: '2021-08-01'
            },
            {
                firstName: 'Piotr',
                lastName: 'Wiśniewski',
                email: 'p.wisniewski@company.com',
                jobTitle: 'Backend Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2023-03-10'
            },
            {
                firstName: 'Maria',
                lastName: 'Dąbrowska',
                email: 'm.dabrowska@company.com',
                jobTitle: 'HR Manager',
                groups: [{name: 'HR'}],
                employedSince: '2020-11-20'
            },
            {
                firstName: 'Tomasz',
                lastName: 'Lewandowski',
                email: 't.lewandowski@company.com',
                jobTitle: 'Frontend Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2022-06-15'
            },
            {
                firstName: 'Katarzyna',
                lastName: 'Wójcik',
                email: 'k.wojcik@company.com',
                jobTitle: 'Product Manager',
                groups: [{name: 'Management'}],
                employedSince: '2021-04-01'
            },
            {
                firstName: 'Michał',
                lastName: 'Kamiński',
                email: 'm.kaminski@company.com',
                jobTitle: 'DevOps Engineer',
                groups: [{name: 'Tech'}],
                employedSince: '2023-01-10'
            },
            {
                firstName: 'Agnieszka',
                lastName: 'Zielińska',
                email: 'a.zielinska@company.com',
                jobTitle: 'UX Researcher',
                groups: [{name: 'Design'}],
                employedSince: '2022-09-01'
            },
            {
                firstName: 'Krzysztof',
                lastName: 'Szymański',
                email: 'k.szymanski@company.com',
                jobTitle: 'Backend Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2021-12-15'
            },
            {
                firstName: 'Magdalena',
                lastName: 'Pawlak',
                email: 'm.pawlak@company.com',
                jobTitle: 'HR Specialist',
                groups: [{name: 'HR'}],
                employedSince: '2023-02-01'
            },
            {
                firstName: 'Robert',
                lastName: 'Jabłoński',
                email: 'r.jablonski@company.com',
                jobTitle: 'iOS Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2022-03-15'
            },
            {
                firstName: 'Ewa',
                lastName: 'Kaczmarek',
                email: 'e.kaczmarek@company.com',
                jobTitle: 'Graphic Designer',
                groups: [{name: 'Design'}],
                employedSince: '2021-07-01'
            },
            {
                firstName: 'Marcin',
                lastName: 'Piotrowski',
                email: 'm.piotrowski@company.com',
                jobTitle: 'Frontend Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2023-04-10'
            },
            {
                firstName: 'Joanna',
                lastName: 'Michalska',
                email: 'j.michalska@company.com',
                jobTitle: 'Office Manager',
                groups: [{name: 'Administration'}],
                employedSince: '2020-10-01'
            },
            {
                firstName: 'Paweł',
                lastName: 'Adamczyk',
                email: 'p.adamczyk@company.com',
                jobTitle: 'Full Stack Developer',
                groups: [{name: 'Tech'}],
                employedSince: '2022-08-15'
            },
            {
                firstName: 'Alicja',
                lastName: 'Nowicka',
                email: 'a.nowicka@company.com',
                jobTitle: 'Marketing Specialist',
                groups: [{name: 'Marketing'}],
                employedSince: '2021-09-01'
            },
            {
                firstName: 'Kamil',
                lastName: 'Grabowski',
                email: 'k.grabowski@company.com',
                jobTitle: 'QA Engineer',
                groups: [{name: 'Tech'}],
                employedSince: '2023-01-15'
            },
            {
                firstName: 'Monika',
                lastName: 'Zawadzka',
                email: 'm.zawadzka@company.com',
                jobTitle: 'UI Designer',
                groups: [{name: 'Design'}],
                employedSince: '2022-05-01'
            },
            {
                firstName: 'Łukasz',
                lastName: 'Walczak',
                email: 'l.walczak@company.com',
                jobTitle: 'System Administrator',
                groups: [{name: 'Tech'}],
                employedSince: '2021-11-10'
            },
            {
                firstName: 'Barbara',
                lastName: 'Sikora',
                email: 'b.sikora@company.com',
                jobTitle: 'Business Analyst',
                groups: [{name: 'Management'}],
                employedSince: '2022-07-01'
            }
        ]
    }
</script>

<div class="px-10">
    <Searchbar placeholderText="Szukaj pracownika..." />
    <EmployeeList {data}/>
</div>