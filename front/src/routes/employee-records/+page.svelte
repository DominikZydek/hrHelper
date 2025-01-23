<script>
    import EmployeeList from "../../components/EmployeeList.svelte";
    import Searchbar from "../../components/Searchbar.svelte";
    import Slider from "../../components/Slider.svelte";

    const data = {
        employees: [{
            firstName: 'Jan',
            lastName: 'Kowalski',
            sex: 'Mężczyzna',
            email: 'j.kowalski@company.com',
            birthDate: '03/11/1987',
            phoneNumber: '+48221389987',
            address: {
                streetName: 'Ogrodowa',
                number: '21/4',
                postalCode: '33-109',
                city: 'Wieliczka'
            },
            jobTitle: 'Android Developer',
            reportsTo: 'Andrzej Siwy',
            groups: [{name: 'Tech'}],
            approvalProcess: {},
            typeOfEmployment: 'UoP',
            paidTimeOffDays: '26',
            workingTime: '1/2',
            employedFrom: '2022-01-15',
            employedTo: null,
            healthCheckExpiredBy: '12/11/2026',
            healthAndSafetyTrainingExpiredBy: '11/06/2021'
        },
            {
                firstName: 'Anna',
                lastName: 'Nowak',
                sex: 'Kobieta',
                email: 'a.nowak@company.com',
                birthDate: '15/04/1992',
                phoneNumber: '+48504678123',
                address: {
                    streetName: 'Krakowska',
                    number: '45',
                    postalCode: '30-001',
                    city: 'Kraków'
                },
                jobTitle: 'HR Specialist',
                reportsTo: 'Maria Wiśniewska',
                groups: [{name: 'HR'}, {name: 'Recruitment'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2021-03-01',
                employedTo: null,
                healthCheckExpiredBy: '10/03/2025',
                healthAndSafetyTrainingExpiredBy: '01/03/2024'
            },
            {
                firstName: 'Piotr',
                lastName: 'Wiśniewski',
                sex: 'Mężczyzna',
                email: 'p.wisniewski@company.com',
                birthDate: '22/07/1985',
                phoneNumber: '+48602345678',
                address: {
                    streetName: 'Długa',
                    number: '12/3',
                    postalCode: '31-124',
                    city: 'Kraków'
                },
                jobTitle: 'Frontend Developer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Frontend'}],
                approvalProcess: {},
                typeOfEmployment: 'B2B',
                paidTimeOffDays: '20',
                workingTime: '1',
                employedFrom: '2023-06-01',
                employedTo: '2024-05-31',
                healthCheckExpiredBy: '15/05/2025',
                healthAndSafetyTrainingExpiredBy: '01/06/2024'
            },
            {
                firstName: 'Maria',
                lastName: 'Wiśniewska',
                sex: 'Kobieta',
                email: 'm.wisniewska@company.com',
                birthDate: '01/12/1978',
                phoneNumber: '+48505123456',
                address: {
                    streetName: 'Mickiewicza',
                    number: '8/12',
                    postalCode: '31-110',
                    city: 'Kraków'
                },
                jobTitle: 'HR Director',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'HR'}, {name: 'Management'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2019-01-01',
                employedTo: null,
                healthCheckExpiredBy: '20/12/2025',
                healthAndSafetyTrainingExpiredBy: '15/01/2024'
            },
            {
                firstName: 'Tomasz',
                lastName: 'Lewandowski',
                sex: 'Mężczyzna',
                email: 't.lewandowski@company.com',
                birthDate: '11/09/1990',
                phoneNumber: '+48603234567',
                address: {
                    streetName: 'Słowackiego',
                    number: '15',
                    postalCode: '30-001',
                    city: 'Kraków'
                },
                jobTitle: 'UX Designer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Design'}, {name: 'Tech'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2022-03-15',
                employedTo: null,
                healthCheckExpiredBy: '10/03/2026',
                healthAndSafetyTrainingExpiredBy: '15/03/2024'
            },
            {
                firstName: 'Karolina',
                lastName: 'Dąbrowska',
                sex: 'Kobieta',
                email: 'k.dabrowska@company.com',
                birthDate: '25/03/1993',
                phoneNumber: '+48504987654',
                address: {
                    streetName: 'Poznańska',
                    number: '3/7',
                    postalCode: '30-012',
                    city: 'Kraków'
                },
                jobTitle: 'Backend Developer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Backend'}],
                approvalProcess: {},
                typeOfEmployment: 'B2B',
                paidTimeOffDays: '20',
                workingTime: '4/5',
                employedFrom: '2023-01-01',
                employedTo: '2024-12-31',
                healthCheckExpiredBy: '25/12/2024',
                healthAndSafetyTrainingExpiredBy: '01/01/2024'
            },
            {
                firstName: 'Michał',
                lastName: 'Zieliński',
                sex: 'Mężczyzna',
                email: 'm.zielinski@company.com',
                birthDate: '18/06/1988',
                phoneNumber: '+48602123456',
                address: {
                    streetName: 'Warszawska',
                    number: '22/5',
                    postalCode: '31-155',
                    city: 'Kraków'
                },
                jobTitle: 'Project Manager',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'Management'}, {name: 'Tech'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2020-09-01',
                employedTo: null,
                healthCheckExpiredBy: '15/09/2025',
                healthAndSafetyTrainingExpiredBy: '01/09/2024'
            },
            {
                firstName: 'Aleksandra',
                lastName: 'Wojciechowska',
                sex: 'Kobieta',
                email: 'a.wojciechowska@company.com',
                birthDate: '30/11/1991',
                phoneNumber: '+48505678901',
                address: {
                    streetName: 'Dietla',
                    number: '45/12',
                    postalCode: '31-046',
                    city: 'Kraków'
                },
                jobTitle: 'QA Engineer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'QA'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2022-07-01',
                employedTo: null,
                healthCheckExpiredBy: '30/06/2025',
                healthAndSafetyTrainingExpiredBy: '01/07/2024'
            },
            {
                firstName: 'Marcin',
                lastName: 'Kaczmarek',
                sex: 'Mężczyzna',
                email: 'm.kaczmarek@company.com',
                birthDate: '14/02/1986',
                phoneNumber: '+48603345678',
                address: {
                    streetName: 'Lea',
                    number: '10/3',
                    postalCode: '30-049',
                    city: 'Kraków'
                },
                jobTitle: 'DevOps Engineer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'DevOps'}],
                approvalProcess: {},
                typeOfEmployment: 'B2B',
                paidTimeOffDays: '20',
                workingTime: '1',
                employedFrom: '2023-03-01',
                employedTo: '2025-02-28',
                healthCheckExpiredBy: '28/02/2025',
                healthAndSafetyTrainingExpiredBy: '01/03/2024'
            },
            {
                firstName: 'Magdalena',
                lastName: 'Szymańska',
                sex: 'Kobieta',
                email: 'm.szymanska@company.com',
                birthDate: '07/08/1994',
                phoneNumber: '+48504234567',
                address: {
                    streetName: 'Krowoderska',
                    number: '25/8',
                    postalCode: '31-142',
                    city: 'Kraków'
                },
                jobTitle: 'Marketing Specialist',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'Marketing'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '3/4',
                employedFrom: '2022-11-15',
                employedTo: null,
                healthCheckExpiredBy: '15/11/2024',
                healthAndSafetyTrainingExpiredBy: '15/11/2023'
            },
            {
                firstName: 'Krzysztof',
                lastName: 'Wójcik',
                sex: 'Mężczyzna',
                email: 'k.wojcik@company.com',
                birthDate: '19/05/1983',
                phoneNumber: '+48602456789',
                address: {
                    streetName: 'Karmelicka',
                    number: '30/4',
                    postalCode: '31-128',
                    city: 'Kraków'
                },
                jobTitle: 'Sales Manager',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'Sales'}, {name: 'Management'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2020-01-15',
                employedTo: null,
                healthCheckExpiredBy: '15/01/2026',
                healthAndSafetyTrainingExpiredBy: '15/01/2024'
            },
            {
                firstName: 'Natalia',
                lastName: 'Kamińska',
                sex: 'Kobieta',
                email: 'n.kaminska@company.com',
                birthDate: '23/09/1989',
                phoneNumber: '+48505789012',
                address: {
                    streetName: 'Rajska',
                    number: '5/12',
                    postalCode: '31-124',
                    city: 'Kraków'
                },
                jobTitle: 'UI Designer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Design'}, {name: 'Tech'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1/2',
                employedFrom: '2023-04-01',
                employedTo: null,
                healthCheckExpiredBy: '01/04/2025',
                healthAndSafetyTrainingExpiredBy: '01/04/2024'
            },
            {
                firstName: 'Adam',
                lastName: 'Piotrowski',
                sex: 'Mężczyzna',
                email: 'a.piotrowski@company.com',
                birthDate: '12/12/1987',
                phoneNumber: '+48603567890',
                address: {
                    streetName: 'Grodzka',
                    number: '15/3',
                    postalCode: '31-006',
                    city: 'Kraków'
                },
                jobTitle: 'Senior Backend Developer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Backend'}],
                approvalProcess: {},
                typeOfEmployment: 'B2B',
                paidTimeOffDays: '20',
                workingTime: '1',
                employedFrom: '2021-06-01',
                employedTo: '2024-05-31',
                healthCheckExpiredBy: '31/05/2025',
                healthAndSafetyTrainingExpiredBy: '01/06/2024'
            },
            {
                firstName: 'Monika',
                lastName: 'Pawlak',
                sex: 'Kobieta',
                email: 'm.pawlak@company.com',
                birthDate: '28/02/1992',
                phoneNumber: '+48504345678',
                address: {
                    streetName: 'Szewska',
                    number: '8/7',
                    postalCode: '31-009',
                    city: 'Kraków'
                },
                jobTitle: 'Content Writer',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'Marketing'}, {name: 'Content'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '3/4',
                employedFrom: '2022-09-15',
                employedTo: null,
                healthCheckExpiredBy: '15/09/2024',
                healthAndSafetyTrainingExpiredBy: '15/09/2023'
            },
            {
                firstName: 'Łukasz',
                lastName: 'Michalski',
                sex: 'Mężczyzna',
                email: 'l.michalski@company.com',
                birthDate: '05/07/1984',
                phoneNumber: '+48602678901',
                address: {
                    streetName: 'Wielopole',
                    number: '12/9',
                    postalCode: '31-072',
                    city: 'Kraków'
                },
                jobTitle: 'System Administrator',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Infrastructure'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2020-03-01',
                employedTo: null,
                healthCheckExpiredBy: '01/03/2025',
                healthAndSafetyTrainingExpiredBy: '01/03/2024'
            },
            {
                firstName: 'Agnieszka',
                lastName: 'Grabowska',
                sex: 'Kobieta',
                email: 'a.grabowska@company.com',
                birthDate: '16/10/1990',
                phoneNumber: '+48505890123',
                address: {
                    streetName: 'Starowiślna',
                    number: '20/5',
                    postalCode: '31-038',
                    city: 'Kraków'
                },
                jobTitle: 'Office Manager',
                reportsTo: 'Maria Wiśniewska',
                groups: [{name: 'Administration'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2021-09-01',
                employedTo: null,
                healthCheckExpiredBy: '01/09/2024',
                healthAndSafetyTrainingExpiredBy: '01/09/2023'
            },
            {
                firstName: 'Rafał',
                lastName: 'Jankowski',
                sex: 'Mężczyzna',
                email: 'r.jankowski@company.com',
                birthDate: '09/04/1986',
                phoneNumber: '+48603789012',
                address: {
                    streetName: 'Floriańska',
                    number: '25/8',
                    postalCode: '31-019',
                    city: 'Kraków'
                },
                jobTitle: 'iOS Developer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Mobile'}],
                approvalProcess: {},
                typeOfEmployment: 'B2B',
                paidTimeOffDays: '20',
                workingTime: '1',
                employedFrom: '2022-05-15',
                employedTo: '2024-05-14',
                healthCheckExpiredBy: '14/05/2025',
                healthAndSafetyTrainingExpiredBy: '15/05/2024'
            },
            {
                firstName: 'Katarzyna',
                lastName: 'Adamczyk',
                sex: 'Kobieta',
                email: 'k.adamczyk@company.com',
                birthDate: '21/01/1993',
                phoneNumber: '+48504901234',
                address: {
                    streetName: 'Brzozowa',
                    number: '7/3',
                    postalCode: '31-050',
                    city: 'Kraków'
                },
                jobTitle: 'Recruitment Specialist',
                reportsTo: 'Maria Wiśniewska',
                groups: [{name: 'HR'}, {name: 'Recruitment'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '4/5',
                employedFrom: '2023-02-01',
                employedTo: null,
                healthCheckExpiredBy: '01/02/2025',
                healthAndSafetyTrainingExpiredBy: '01/02/2024'
            },
            {
                firstName: 'Bartosz',
                lastName: 'Sikora',
                sex: 'Mężczyzna',
                email: 'b.sikora@company.com',
                birthDate: '03/12/1988',
                phoneNumber: '+48602012345',
                address: {
                    streetName: 'Długa',
                    number: '30/12',
                    postalCode: '31-146',
                    city: 'Kraków'
                },
                jobTitle: 'Security Engineer',
                reportsTo: 'Andrzej Siwy',
                groups: [{name: 'Tech'}, {name: 'Security'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2021-11-01',
                employedTo: null,
                healthCheckExpiredBy: '01/11/2024',
                healthAndSafetyTrainingExpiredBy: '01/11/2023'
            },
            {
                firstName: 'Marek',
                lastName: 'Jankowski',
                sex: 'Mężczyzna',
                email: 'm.jankowski@company.com',
                birthDate: '15/08/1975',
                phoneNumber: '+48505123789',
                address: {
                    streetName: 'Krupnicza',
                    number: '16/4',
                    postalCode: '31-123',
                    city: 'Kraków'
                },
                jobTitle: 'CEO',
                reportsTo: null,
                groups: [{name: 'Management'}, {name: 'Board'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2019-01-01',
                employedTo: null,
                healthCheckExpiredBy: '01/01/2026',
                healthAndSafetyTrainingExpiredBy: '01/01/2024'
            },
            {
                firstName: 'Andrzej',
                lastName: 'Siwy',
                sex: 'Mężczyzna',
                email: 'a.siwy@company.com',
                birthDate: '28/06/1980',
                phoneNumber: '+48602345987',
                address: {
                    streetName: 'Sebastiana',
                    number: '9/15',
                    postalCode: '31-049',
                    city: 'Kraków'
                },
                jobTitle: 'CTO',
                reportsTo: 'Marek Jankowski',
                groups: [{name: 'Tech'}, {name: 'Management'}, {name: 'Board'}],
                approvalProcess: {},
                typeOfEmployment: 'UoP',
                paidTimeOffDays: '26',
                workingTime: '1',
                employedFrom: '2019-01-01',
                employedTo: null,
                healthCheckExpiredBy: '01/01/2026',
                healthAndSafetyTrainingExpiredBy: '01/01/2024'
            }]
    }

    let selectedEmployee = null
    const onClick = (employee) => {
        selectedEmployee = employee
        toggleSlider()
    }

    let showSlider = false
    const toggleSlider = () => {
        showSlider = !showSlider
    }
</script>

<div class="px-10">
    <Searchbar placeholderText="Szukaj pracownika..." />
    <EmployeeList {data} {onClick}/>
    <Slider {showSlider} {toggleSlider} employee={selectedEmployee}/>
</div>